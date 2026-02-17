<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use Illuminate\Support\Facades\Crypt;


class BlogController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalBlogs'     => Blog::count(),
            'activeBlogs'    => Blog::where('status', 'active')->count(),
            'inactiveBlogs'  => Blog::where('status', 'inactive')->count(),
            'newBlogs'       => Blog::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'latestBlogs'    => Blog::with('category')->latest()->limit(12)->get(),
            'blogs'          => Blog::with('category')->latest()->paginate(12)
        ]);
    }

    public function index()
    {
        $perPage = 12; // You can adjust this as needed
        $blogs = Blog::with('category')->latest()->paginate($perPage);
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
            'status'  => 'nullable|in:active,inactive',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
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
            'status'          => $request->status ?? 'active',
            'category_id'     => $request->category_id,
            'tags'            => $request->tags,
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

    /**
     * Handle AJAX request to download image from provided URL,
     * save it to public/assets/images/blogs, and return the accessible URL.
     */
    public function imageFromUrl(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url'
        ]);

        $imageUrl = $request->input('image_url');

        try {
            // Try to fetch image contents
            $imageContents = @file_get_contents($imageUrl);

            if ($imageContents === false) {
                // Could not fetch image data, but per prompt,
                // if NOT imagenot (image can't be gotten), then still show the URL as fallback
                return response()->json([
                    'success' => true,
                    'image_url' => $imageUrl,
                    'fallback' => true,
                    'message' => 'Could not fetch the image from the provided URL. Using the original URL directly.'
                ]);
            }

            // Get filename/extension
            $parsedUrl = parse_url($imageUrl);
            $basename = isset($parsedUrl['path']) ? basename($parsedUrl['path']) : null;
            $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

            // Allowed extensions for safety
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
            if (!in_array($ext, $allowedExts)) {
                // Try to detect extension from response headers/Finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_buffer($finfo, $imageContents);
                $map = [
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/gif'  => 'gif',
                    'image/webp' => 'webp',
                    'image/bmp'  => 'bmp',
                ];
                $ext = $map[$mime] ?? 'jpg';
                finfo_close($finfo);
            }

            // Create folder for blogs if not exists
            $folder = public_path('assets/images/blogs');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            // Generate unique filename
            $fileName = 'extimg_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $ext;
            $filePath = $folder . '/' . $fileName;

            // Save file to public path
            file_put_contents($filePath, $imageContents);

            // Return the URL for browser access
            $publicUrl = '/assets/images/blogs/' . $fileName;

            return response()->json([
                'success' => true,
                'image_url' => $publicUrl
            ]);
        } catch (\Exception $e) {
            // On any exception, fall back to showing the original URL (just like above)
            return response()->json([
                'success' => true,
                'image_url' => $imageUrl,
                'fallback' => true,
                'message' => 'Could not fetch the image from the provided URL. Using the original URL directly.'
            ]);
        }
    }

    public function create()
    {
        // Re‑use the same advanced editor view for create & edit
        return view('admin.blogs.create', [
            'blog'   => null,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show($id)
    {
        $decryptedId = Crypt::decrypt($id);

        $blog = Blog::findOrFail($decryptedId);
        return view('admin.blogs.view', compact('blog'));
    }

    /**
     * Edit – reuses the same Blade as create
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decrypt($id);

        $blog = Blog::findOrFail($decryptedId);

        return view('admin.blogs.create', [
            'blog' => $blog,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update blog – mirror logic from store()
     * so that the Gutenberg editor works for edits too.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decrypt($id);

        $blog = Blog::findOrFail($decryptedId);

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'nullable|in:active,inactive',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
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
            'category_id'     => $request->category_id,
            'tags'            => $request->tags,
        ]);

        return back()->with('success', 'Blog updated successfully');
    }

    public function delete($id)
    {
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decrypt($id);
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid blog id');
        }

        $blog = \App\Models\Blog::find($decryptedId);

        if (!$blog) {
            return back()->with('error', 'Blog not found');
        }

        $blog->delete();

        return back()->with('success', 'Blog deleted');
    }
    public function publicBlogs()
    {
        $perPage = 10;
        $blogs = Blog::where('status', 'active')->orderBy('id', 'desc')->paginate($perPage);
        return view('pages.blogs', compact('blogs'));
    }
    public function view($id, $title = null)
    {
        $blog = Blog::findOrFail($id);

        return view('pages.blogs_view', compact('blog'));
    }
}
