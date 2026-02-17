<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $items = MenuItem::with(['menuParent', 'itemParent'])
            ->orderBy('sort_order')
            ->paginate($perPage);

        return view('admin.menu_items.index', compact('items'));
    }

    public function create(Request $request)
    {
        $item = new MenuItem();

        if ($request->parent_type) {
            $item->parent_type = $request->parent_type;
        }

        if ($request->parent_id) {
            $item->parent_id = $request->parent_id;
        }

        return view('admin.menu_items.create', [
            'item' => $item,
            'menus' => Menu::where('status', 'active')->get(),
            'menuItems' => MenuItem::orderBy('title')->get(),
            'formMode' => 'create'
        ]);
    }

    public function store(Request $request)
    {
        // XSRF (CSRF) VALIDATION (handled by VerifyCsrfToken Middleware in Laravel -- assuming not disabled)
        $data = $this->validateData($request);

        // Data clean-up: Trim all string fields to remove extra spaces, nullify if only spaces
        array_walk($data, function (&$value) {
            if (is_string($value)) {
                $value = trim($value);
                if ($value === '') {
                    $value = null;
                }
            }
        });

        $data['sort_order'] = isset($data['sort_order']) ? (int)$data['sort_order'] : 0;
        $data['created_by'] = session('admin_id');
        $data['updated_by'] = session('admin_id');

        MenuItem::create($data);

        // If AJAX request (from navbar tree modal)
        if ($request->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item created');
    }

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);

        return view('admin.menu_items.create', [
            'item' => $item,
            'menus' => Menu::where('status', 'active')->get(),
            'menuItems' => MenuItem::where('id', '!=', $id)->orderBy('title')->get(),
            'formMode' => 'edit'
        ]);
    }

    public function update(Request $request, $id)
    {
        // XSRF (CSRF) VALIDATION (handled by middleware)
        $item = MenuItem::findOrFail($id);

        $data = $this->validateData($request);

        // Data clean-up: Trim all string fields to remove extra spaces, nullify if only spaces
        array_walk($data, function (&$value) {
            if (is_string($value)) {
                $value = trim($value);
                if ($value === '') {
                    $value = null;
                }
            }
        });

        $data['sort_order'] = isset($data['sort_order']) ? (int)$data['sort_order'] : 0;
        $data['updated_by'] = session('admin_id');

        $item->update($data);
        if ($request->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item updated');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $this->deleteRecursive($id);
        });

        return back()->with('success', 'Menu item deleted');
    }

    /*
    |--------------------------------
    | Shared Validation
    |--------------------------------
    */
    private function validateData(Request $request)
    {
        // Default Laravel CSRF validation occurs automatically.
        return $request->validate([
            'parent_type' => 'required|in:menu,menu_item',
            'parent_id' => 'required|integer|min:1',
            'title' => 'required|max:150',
            'description' => 'nullable',
            'icon' => 'nullable',
            'route_name' => 'nullable|required_without:url',
            // Make 'url' truly optional; if both 'route_name' and 'url' are blank, that's allowed
            'url' => 'nullable',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);
    }

    /*
    |--------------------------------
    | Recursive Delete
    |--------------------------------
    */
    private function deleteRecursive($id)
    {
        $children = MenuItem::where('parent_type', 'menu_item')
            ->where('parent_id', $id)
            ->get();

        foreach ($children as $child) {
            $this->deleteRecursive($child->id);
        }

        MenuItem::destroy($id);
    }

    public function form(Request $request)
    {
        $item = new \App\Models\MenuItem();

        $menus = \App\Models\Menu::where('status', 'active')->get();
        $menuItems = \App\Models\MenuItem::all();

        $formMode = 'create';

        // Auto detect parent if menu_id passed
        if ($request->menu_id) {
            $item->parent_type = 'menu';
            $item->parent_id = $request->menu_id;
        }

        return view('admin.menu_items.form', compact(
            'item',
            'menus',
            'menuItems',
            'formMode'
        ));
    }
    public function show($id)
    {
        abort(404);
    }
}
