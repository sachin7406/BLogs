@extends('admin.layouts.app')

@php
// Use passed $formMode if available (controller provides it), else fallback for older code:
$formMode = $formMode ?? (isset($item) && $item->exists ? 'edit' : 'create');
$backUrl = route('admin.menu-items.index');
$backTitle = "Menu Items";
@endphp

@section('content')
<div class="menus-from" style="max-width: 520px; margin: 2rem auto; background: #fcfcfc; border-radius: 10px; box-shadow: 0 2px 8px #ececec; padding: 32px 26px;">
    <h2 style="text-align: center; margin-bottom: 1.7rem; letter-spacing:1px;">
        {{ $formMode === 'edit' ? 'Edit Menu Item' : 'Create Menu Item' }}
    </h2>

    <form method="POST"
        action="{{ $formMode === 'edit'
                ? route('admin.menu-items.update', $item->id ?? 0)
                : route('admin.menu-items.store') }}">
        @csrf
        @if($formMode === 'edit')
        @method('PUT')
        @endif

        {{-- Parent Type --}}
        <div style="margin-bottom: 1.3em;">
            <label for="parent_type" style="display:block; font-weight:bold;">
                Parent Type <span style="color:red">*</span>
            </label>
            <select name="parent_type" id="parent_type" class="form-control" style="width:100%;padding:7px;" required onchange="filterParentOptions(false); autoGenerateUrlAndRoute();">
                <option value="" disabled {{ old('parent_type', $item->parent_type ?? '') == '' ? 'selected' : '' }}>Select Parent Type</option>
                <option value="menu" {{ old('parent_type', $item->parent_type ?? '') == 'menu' ? 'selected' : '' }}>Menu</option>
                <option value="menu_item" {{ old('parent_type', $item->parent_type ?? '') == 'menu_item' ? 'selected' : '' }}>Menu Item</option>
            </select>
            @error('parent_type')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Parent --}}
        <div style="margin-bottom: 1.3em;">
            <label for="parent_id" style="font-weight:bold;">Parent <span style="color:red">*</span></label>
            <select name="parent_id" id="parent_id" class="form-control" required onchange="autoGenerateUrlAndRoute();">
                <option value="">Select Parent</option>

                {{-- Menus --}}
                @foreach($menus as $m)
                <option value="{{ $m->id }}"
                    data-type="menu"
                    data-slug="{{ \Illuminate\Support\Str::slug($m->title) }}"
                    style="{{ (old('parent_type', $item->parent_type ?? '') && old('parent_type', $item->parent_type ?? '') != 'menu') ? 'display:none;' : '' }}"
                    {{ old('parent_type', $item->parent_type ?? '') == 'menu'
                    && (string)old('parent_id', $item->parent_id ?? '') === (string)$m->id
                    ? 'selected' : '' }}>
                    📁 {{ $m->title }}
                </option>
                @endforeach

                {{-- Menu Items --}}
                @foreach($menuItems as $mi)
                <option value="{{ $mi->id }}"
                    data-type="menu_item"
                    data-parent-menuid="{{ $mi->menu_id }}"
                    data-parent-menu-slug="@php
                        $menu = $menus->firstWhere('id', $mi->menu_id);
                        echo $menu ? \Illuminate\Support\Str::slug($menu->title) : '';
                    @endphp"
                    data-slug="{{ \Illuminate\Support\Str::slug($mi->title) }}"
                    data-raw-menu-title="@php $menu = $menus->firstWhere('id', $mi->menu_id); echo $menu ? $menu->title : ''; @endphp"
                    data-raw-item-title="{{ $mi->title }}"
                    style="{{ (old('parent_type', $item->parent_type ?? '') && old('parent_type', $item->parent_type ?? '') != 'menu_item') ? 'display:none;' : '' }}"
                    {{ old('parent_type', $item->parent_type ?? '') == 'menu_item'
                    && (string)old('parent_id', $item->parent_id ?? '') === (string)$mi->id
                    ? 'selected' : '' }}>

                    ↳ {{ $mi->title }}
                </option>
                @endforeach
            </select>
            @error('parent_id')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>


        <div style="margin-bottom: 1.3em;">
            <label for="title" style="display:block; font-weight:bold;">
                Title <span style="color:red">*</span>
            </label>
            <input name="title" id="title" type="text"
                class="form-control"
                style="width:100%;padding:7px;"
                maxlength="191"
                value="{{ old('title', $item->title ?? '') }}"
                required
                oninput="autoGenerateUrlAndRoute();">
            @error('title')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1.3em;">
            <label for="description" style="display:block; font-weight:bold;">Description</label>
            <input name="description" id="description" type="text"
                class="form-control"
                style="width:100%;padding:7px;"
                maxlength="255"
                value="{{ old('description', $item->description ?? '') }}">
            @error('description')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Icon field: Simple dropdown with custom textbox --}}
        <div style="margin-bottom: 1.3em;">
            <label for="icon" style="display:block; font-weight:bold;">
                Icon
                <span style="color: #aaa; font-style:italic;">(optional)</span>
            </label>
            <select
                name="icon_select"
                id="icon_select"
                class="form-select"
                style="width:100%;padding:7px; margin-bottom: 8px;"
                onchange="document.getElementById('icon').value = this.value;">
                <option value="">-- Select Icon --</option>
                @php
                // Common FontAwesome icon class options for dropdown (customize as needed)
                $fontawesomeIcons = [
                'fa fa-home' => 'Home',
                'fa fa-user' => 'User',
                'fa fa-cog' => 'Cog',
                'fa fa-star' => 'Star',
                'fa fa-heart' => 'Heart',
                'fa fa-envelope' => 'Envelope',
                'fa fa-book' => 'Book',
                'fa fa-globe' => 'Globe',
                'fa fa-list' => 'List',
                'fa fa-gear' => 'Gear',
                ];
                @endphp
                @foreach($fontawesomeIcons as $faClass => $faName)
                <option value="{{ $faClass }}" {{ old('icon', $item->icon ?? '') == $faClass ? 'selected' : '' }}>
                    {{ $faName }} ({{ $faClass }})
                </option>
                @endforeach
            </select>
            <input name="icon"
                id="icon"
                type="text"
                class="form-control"
                style="width:100%;padding:7px;margin-top: 4px;"
                maxlength="100"
                value="{{ old('icon', $item->icon ?? '') }}"
                placeholder="Or enter custom FontAwesome class">
            <small style="font-size:0.97em;color:#777;">You may pick from the dropdown or enter your own icon class.</small>
            @error('icon')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>


        <div style="margin-bottom: 1.3em;">
            <label for="route_name" style="display:block; font-weight:bold;">
                Route Name <span style="color:red">*</span>
            </label>
            <input name="route_name" id="route_name" type="text"
                class="form-control"
                style="width:100%;padding:7px;"
                maxlength="191"
                value="{{ old('route_name', $item->route_name ?? '') }}"
                placeholder="route.name"
                required
                readonly
                onclick="this.readOnly=false;">
            <small style="font-size:0.97em;color:#777;">Auto-generated based on parent and title. You can edit this value if needed.</small>
            @error('route_name')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1.3em;">
            <label for="url" style="display:block; font-weight:bold;">
                URL <span style="color:#777; font-style:italic;">(auto generated from parent and title, but you may edit)</span>
            </label>
            <input name="url" id="url" type="text"
                class="form-control"
                style="width:100%;padding:7px;"
                maxlength="255"
                value="{{ old('url', $item->url ?? '') }}"
                placeholder="/parent/title"
                required
                readonly
                onclick="this.readOnly=false;">
            <small style="font-size:0.97em;color:#777;">Auto-generated based on parent and title. You can edit this value if needed.</small>
            @error('url')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1.3em;">
            <label for="sort_order" style="display:block; font-weight:bold;">
                Sort Order <span style="color:red">*</span>
            </label>
            <input name="sort_order" id="sort_order" type="number"
                class="form-control"
                style="width:100%;padding:7px;"
                value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                required>
            @error('sort_order')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1.5em;">
            <label for="status" style="display:block; font-weight:bold;">
                Status <span style="color:red">*</span>
            </label>
            <select name="status" id="status"
                class="form-control"
                style="width:100%;padding:7px 10px;"
                required>
                <option value="" disabled {{ (old('status', $item->status ?? 'active') == '') ? 'selected' : '' }}>Select Status</option>
                <option value="active" {{ (old('status', $item->status ?? 'active') == 'active') ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ (old('status', $item->status ?? 'active') == 'inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="text-align: right;">
            <button type="submit"
                style="background: linear-gradient(90deg, #4781ff 50%, #264fa3 100%);
                        color: #fff; padding: 9px 27px;
                        font-size: 1.08em; border-radius: 4px;
                        border:0; box-shadow: 0 2px 4px #dbeafe; cursor:pointer;">
                {{ $formMode === 'edit' ? 'Update Menu Item' : 'Create Menu Item' }}
            </button>
        </div>
    </form>
</div>

<script>
    function filterParentOptions(preserveSelected = false) {
        const parentTypeSelect = document.getElementById('parent_type');
        const parentIdSelect = document.getElementById('parent_id');
        if (!parentTypeSelect || !parentIdSelect) return;

        const selectedType = parentTypeSelect.value;
        let lastSelected = parentIdSelect.value;

        Array.from(parentIdSelect.options).forEach(function(option) {
            if (!option.value) return; // skip "Select Parent"
            const optionType = option.getAttribute('data-type');
            if (optionType === selectedType) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // If not preserving the current selection on change, reset selection
        if (!preserveSelected) {
            parentIdSelect.value = "";
        } else if (lastSelected) {
            // If preserving, make sure it's still visible. If not, reset.
            const selectedOption = parentIdSelect.querySelector('option[value="' + lastSelected + '"]');
            if (selectedOption && selectedOption.style.display === 'block') {
                parentIdSelect.value = lastSelected;
            } else {
                parentIdSelect.value = "";
            }
        }
    }

    // Slugify function as before
    function slugify(text) {
        return text
            .toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .replace(/\s+/g, ' ') // collapse multiple spaces to one
            .trim()
            .replace(/[^a-z0-9]+/g, '-') // replace non-alphanumeric (or space) with hyphen
            .replace(/-+/g, '-') // merge consecutive hyphens
            .replace(/^-+|-+$/g, ''); // trim leading/trailing hyphens
    }

    // Recursively retrieve the path/route for the menu item ancestry
    function getMenuItemAncestryPath(menuItems, menusMap, currentId, type, isRoute = false) {
        var path = [];
        if (type === 'menu') {
            // Current is menu, return its slug/name
            var menu = menusMap[currentId];
            if (menu) {
                path.unshift(isRoute ? slugify(menu.title) : slugify(menu.title));
            }
        } else if (type === 'menu_item') {
            // Find menu item
            var mi = menuItems.find(function(mi) {
                return mi.id == currentId;
            });
            if (mi) {
                // Push menu item's slug/title
                path.unshift(isRoute ? slugify(mi.title) : slugify(mi.title));
                if (mi.parent_type === 'menu') {
                    // Parent is menu
                    var menu = menusMap[mi.parent_id];
                    if (menu) {
                        path.unshift(isRoute ? slugify(menu.title) : slugify(menu.title));
                    }
                } else if (mi.parent_type === 'menu_item') {
                    // Recursive: parent is menu item
                    var parentPath = getMenuItemAncestryPath(menuItems, menusMap, mi.parent_id, 'menu_item', isRoute);
                    path = parentPath.concat(path);
                }
            }
        }
        return path;
    }

    // Capture all menus and menuItems from backend for recursion
    const MENUS_MAP = (function() {
        var data = {};
        @foreach($menus as $menu)
        data[{{ $menu->id }}] = {
            id: {{ $menu->id }},
            title: @json($menu->title)
        };
        @endforeach
        return data;
    })();

    const MENU_ITEMS_DB = [
        @foreach($menuItems as $mi)
        {
            id: {{ $mi->id }},
            title: @json($mi->title),
            parent_id: @json($mi->parent_id),
            parent_type: @json($mi->parent_type)
        },
        @endforeach
    ];

    function autoGenerateUrlAndRoute() {
        const parentType = document.getElementById('parent_type').value;
        const parentIdSel = document.getElementById('parent_id');
        const parentOption = parentIdSel.options[parentIdSel.selectedIndex];
        const titleValue = document.getElementById('title').value;
        const urlInput = document.getElementById('url');
        const routeInput = document.getElementById('route_name');

        if (!parentType || !parentOption || !parentOption.value || !titleValue) {
            return;
        }

        let autoUrl = '';
        let autoRoute = '';

        if (parentType === 'menu') {
            // Path: menu-slug/title-slug
            let parentSlug = slugify(parentOption.getAttribute('data-slug') || parentOption.value);
            let slugTitle = slugify(titleValue);
            autoUrl = '/' + parentSlug + '/' + slugTitle;
            autoRoute = parentSlug + '.' + slugTitle;
        } else if (parentType === 'menu_item') {
            // Recursively collect all ancestors
            let parentItemId = parentOption.value;
            let ancestryPath = getMenuItemAncestryPath(MENU_ITEMS_DB, MENUS_MAP, parentItemId, 'menu_item', false);
            let ancestryRoute = getMenuItemAncestryPath(MENU_ITEMS_DB, MENUS_MAP, parentItemId, 'menu_item', true);

            let slugTitle = slugify(titleValue);
            let fullPath = ancestryPath.concat([slugTitle]);
            let fullRoute = ancestryRoute.concat([slugTitle]);

            autoUrl = '/' + fullPath.join('/');
            autoRoute = fullRoute.join('.');
        }

        // Ensure single slashes and no trailing
        if (urlInput) {
            urlInput.value = autoUrl.replace(/\/{2,}/g, '/').replace(/\/$/, '');
        }
        if (routeInput) {
            routeInput.value = autoRoute.replace(/\.{2,}/g, '.').replace(/\.$/, '');
        }
    }

    // ---- event listeners and page load ----
    window.addEventListener('DOMContentLoaded', function() {
        filterParentOptions(true);

        // Icon select - put selected value into textbox
        const iconSelect = document.getElementById('icon_select');
        const iconInput = document.getElementById('icon');
        if (iconSelect && iconInput) {
            iconSelect.addEventListener('change', function() {
                if (this.value) {
                    iconInput.value = this.value;
                }
            });
        }

        // Auto route/url on init if needed (for edit)
        autoGenerateUrlAndRoute();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        if (titleInput) {
            titleInput.addEventListener('input', function() {
                autoGenerateUrlAndRoute();
            });
        }
    });

    // Keep select and text input in sync
    document.addEventListener('DOMContentLoaded', function() {
        const iconInput = document.getElementById('icon');
        const iconSelect = document.getElementById('icon_select');
        iconInput.addEventListener('input', function() {
            let found = false;
            for (let i = 0; i < iconSelect.options.length; i++) {
                let o = iconSelect.options[i];
                if (o.value === iconInput.value) {
                    iconSelect.value = o.value;
                    found = true;
                    break;
                }
            }
            if (!found) iconSelect.value = '';
        });
    });
</script>
@endsection