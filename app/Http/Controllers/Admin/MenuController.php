<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('sort_order')->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $menu = new Menu();
        $formMode = 'create';

        return view('admin.menus.create', compact('menu', 'formMode'));
    }

    public function store(Request $request)
    {
        // XSRF/CSRF is protected by middleware by default in Laravel

        $data = $request->validate([
            'title' => 'required|max:100',
            'description' => 'nullable',
            'icon' => 'nullable',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        // Trim all string fields to remove extra spaces and nullify empty ones
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

        Menu::create($data);
        // ✅ If AJAX request (from navbar tree modal)
        if ($request->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu created');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $formMode = 'edit';

        return view('admin.menus.create', compact('menu', 'formMode'));
    }

    public function update(Request $request, $id)
    {
        // XSRF/CSRF is protected by middleware by default in Laravel

        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|max:100',
            'description' => 'nullable',
            'icon' => 'nullable',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        // Trim all string fields to remove extra spaces and nullify empty ones
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

        $menu->update($data);
        // ✅ If AJAX request (from navbar tree modal)
        if ($request->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu updated');
    }

    /*
    |--------------------------------
    | Safe Delete Menu + Items
    |--------------------------------
    */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $menu = Menu::findOrFail($id);

            // delete all related menu items (recursive)
            $items = MenuItem::where('parent_type', 'menu')
                ->where('parent_id', $menu->id)
                ->get();

            foreach ($items as $item) {
                $this->deleteItemRecursive($item->id);
            }

            $menu->delete();
        });

        return back()->with('success', 'Menu deleted');
    }

    /*
    |--------------------------------
    | Recursive MenuItem Delete
    |--------------------------------
    */
    private function deleteItemRecursive($id)
    {
        $children = MenuItem::where('parent_type', 'menu_item')
            ->where('parent_id', $id)
            ->get();

        foreach ($children as $child) {
            $this->deleteItemRecursive($child->id);
        }

        MenuItem::destroy($id);
    }

    /**
     * Show the details of a specific menu.
     * Added method to address missing 'show'
     */
    public function treePreview()
    {
        $menus = Menu::with(['items.childrenRecursive'])
            ->orderBy('sort_order')
            ->get();

        // Gather all MenuItems (if needed by your Blade view)
        $menuItems = \App\Models\MenuItem::all();

        return view('admin.preview.navbar-tree', [
            'menus' => $menus,
            'menuItems' => $menuItems,
        ]);
    }

    // public function treePreview()
    // {
    //     DB::enableQueryLog();
    //     $menus = Menu::with(['items.childrenRecursive'])->orderBy('sort_order')->get();
    //     dd(DB::getQueryLog());
    // }
}
