<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalBlogs'     => Blog::count(),
            'activeBlogs'    => Blog::where('status', 'published')->count(),
            'inactiveBlogs'  => Blog::where('status', 'draft')->count(),
            'newBlogs'       => Blog::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'latestBlogs'    => Blog::latest()->limit(5)->get(),
            'blogs'          => Blog::latest()->paginate(8)
        ]);
    }

    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    /* =========================================
       STORE BLOG (REFERENCE IMAGE FIXED)
    ========================================== */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'nullable|in:draft,published,inactive',
        ]);

        /* =====================================
       Decode content JSON safely
    ====================================== */
        $blocks = json_decode($request->input('content'), true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($blocks)) {
            return back()->with('error', 'Invalid editor content');
        }

        /* =====================================
       1️⃣ Reference Image
       priority: user → first image
    ====================================== */
        $referenceImage = $request->reference_image ?? null;

        if (!$referenceImage) {
            foreach ($blocks as $block) {
                if (
                    ($block['type'] ?? '') === 'image' &&
                    !empty($block['url'])
                ) {
                    $referenceImage = $block['url'];
                    break;
                }
            }
        }

        /* =====================================
       2️⃣ Description
       priority: user → auto extract
    ====================================== */
        $description = $request->description ?? null;

        if (!$description) {
            foreach ($blocks as $block) {
                if (!empty($block['content'])) {
                    $text = strip_tags($block['content']);
                    $text = preg_replace('/\s+/', ' ', $text);
                    $text = trim($text);

                    if (strlen($text) >= 50) {
                        $description = mb_substr($text, 0, 160);
                        if (strlen($text) > 160) {
                            $description .= '...';
                        }
                        break;
                    }
                }
            }
        }

        /* =====================================
       3️⃣ Reference Link
       priority: user → slug URL
    ====================================== */
        $slug = Str::slug($request->title) . '-' . time();

        $referenceLink = $request->reference_link
            ?? url('/blogs/' . $slug);

        /* =====================================
       Store Blog
    ====================================== */
        $data = [
            'title'           => $request->title,
            'slug'            => $slug,
            'content'         => $request->input('content'),
            'description'     => $description,
            'reference_link'  => $referenceLink,
            'reference_image' => $referenceImage,
            'status'          => $request->status ?? 'draft',
            'created_by'      => session('admin_id') ?? 1,
        ];

        Blog::create($data);

        return back()->with('success', 'Blog saved successfully');
    }

    /* =========================================
       IMAGE UPLOAD
    ========================================== */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image'     => 'required|image|max:4096',
            'page_name' => 'nullable|string'
        ]);

        $pageName = $request->page_name
            ? Str::slug($request->page_name)
            : 'blog';

        $path = public_path('assets/images/blogs');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fileName =
            $pageName . '_' .
            time() . '_' .
            Str::random(6) . '.' .
            $request->file('image')->getClientOriginalExtension();

        $request->file('image')->move($path, $fileName);

        return response()->json([
            'success' => true,
            'url'     => '/assets/images/blogs/' . $fileName
        ]);
    }

    public function create()
    {
        // Re‑use the same advanced editor view for create & edit
        return view('admin.blogs.create', [
            'blog'   => null,
        ]);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.view', compact('blog'));
    }

    /**
     * Edit – reuses the same Blade as create
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('admin.blogs.create', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update blog – mirror logic from store()
     * so that the Gutenberg editor works for edits too.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'nullable|in:draft,published,inactive',
        ]);

        $blocks = json_decode($request->input('content'), true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($blocks)) {
            return back()->with('error', 'Invalid editor content')->withInput();
        }

        // Reference image (keep existing if nothing new found)
        $referenceImage = $request->reference_image ?? $blog->reference_image;
        if (!$referenceImage) {
            foreach ($blocks as $block) {
                if (
                    ($block['type'] ?? '') === 'image' &&
                    !empty($block['url'])
                ) {
                    $referenceImage = $block['url'];
                    break;
                }
            }
        }

        // Description
        $description = $request->description ?? $blog->description;
        if (!$description) {
            foreach ($blocks as $block) {
                if (!empty($block['content'])) {
                    $text = strip_tags($block['content']);
                    $text = preg_replace('/\s+/', ' ', $text);
                    $text = trim($text);

                    if (strlen($text) >= 50) {
                        $description = mb_substr($text, 0, 160);
                        if (strlen($text) > 160) {
                            $description .= '...';
                        }
                        break;
                    }
                }
            }
        }

        // Reference link – keep existing unless user sends a new one
        $referenceLink = $request->reference_link ?: $blog->reference_link;

        $blog->update([
            'title'           => $request->title,
            // We intentionally keep the original slug so URLs don't break.
            'content'         => $request->input('content'),
            'description'     => $description,
            'reference_link'  => $referenceLink,
            'reference_image' => $referenceImage,
            'status'          => $request->status ?? $blog->status,
        ]);

        return back()->with('success', 'Blog updated successfully');
    }

    public function delete($id)
    {
        Blog::destroy($id);
        return back()->with('success', 'Blog deleted');
    }

    public function publicBlogs()
    {
        $blogs = Blog::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.blogs', compact('blogs'));
    }
}
