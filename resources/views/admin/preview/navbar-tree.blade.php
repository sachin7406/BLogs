@extends('admin.layouts.app')

@php
$backUrl = route('admin.menus.index');
$backTitle = "Menus";
@endphp

@section('content')

<div class="container-fluid mt-4">
    <div class="row" id="mainRow">
        <div class="col-12" id="treeCol">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary"><i class="bi bi-diagram-3 me-2"></i>Navbar Tree Preview</h2>
                {{-- ROOT ADD MENU --}}
                <button
                    id="addMenuBtn"
                    class="btn btn-success shadow-lg d-flex align-items-center px-3 py-2"
                    style="border-radius: 25px; font-weight: 500;"
                    onclick="handleAddMenuClick()">
                    <i class="bi bi-plus-lg me-2"></i> Add Menu
                </button>
            </div>

            @if($menus->isEmpty())
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-emoji-frown display-5 mb-3"></i>
                <div class="h5 mb-2">No menus found.</div>
                <p class="mb-0">Click <strong>Add Menu</strong> above to get started!</p>
            </div>
            @endif

            <div class="tree-outer-card p-3 rounded-4 shadow-sm bg-light" id="navbarTree">
                @foreach($menus as $menu)
                <div class="tree-node bg-white rounded-3 shadow-sm mb-3 py-2 px-2" style="border:1px solid #d9e1ef;">
                    <div class="node-row justify-content-between align-items-center" style="min-height:38px;">
                        <div class="d-flex align-items-center gap-3">
                            <span class="toggle-btn text-primary fs-5"
                                onclick="toggleNode('menu-{{ $menu->id }}')" role="button" aria-label="Toggle tree">
                                <i class="bi bi-caret-right-fill"></i>
                            </span>
                            <strong class="fs-5">{{ $menu->title }}</strong>
                        </div>
                        <div>
                            <button
                                class="btn btn-primary round-btn shadow-sm add-menu-item-btn"
                                data-menu="{{ $menu->id }}"
                                title="Add Menu Item"
                                style="background:#f1f5fa;border:none;color:#387fe7;"
                                onclick="event.stopPropagation(); handleAddMenuItemForMenu({{ $menu->id }})">
                                <i class="bi bi-plus"></i>
                            </button>


                            <button
                                class="btn btn-warning round-btn shadow-sm ms-2 edit-menu-btn"
                                data-menu="{{ $menu->id }}"
                                title="Edit Menu"
                                style="background:#fffbe6;border:none;color:#e2b200;"
                                onclick="handleEditMenuClick({{ $menu->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                class="btn btn-danger round-btn shadow-sm ms-2 delete-menu-btn"
                                data-menu="{{ $menu->id }}"
                                title="Delete Menu"
                                style="background:#ffe8e6;border:none;color:#e73d30;"
                                onclick="handleDeleteMenuClick({{ $menu->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div id="menu-{{ $menu->id }}" class="node-children">
                        @foreach($menu->items as $item)
                        @include('admin.preview.tree-node', [ 'item' => $item ])
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal for forms -->
<div class="modal fade" style="top :30px" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" id="formModalContent">
            <!-- Dynamic form will be injected here -->
        </div>
    </div>
</div>

@endsection

{{-- styles --}}
<style>
    .tree-outer-card {
        background: linear-gradient(135deg, #e6f0ff 0%, #f9fafc 100%);
        border: 1.5px solid #d1e4ff;
    }

    .tree-node {
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .tree-node:hover {
        box-shadow: 0 8px 24px rgba(46, 122, 225, 0.07);
        border-color: #a7cafc;
    }

    .node-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 0;
        min-height: 32px;
    }

    .node-children {
        display: none;
        margin-left: 38px;
        border-left: 2px dashed #bbc4d3;
        padding-left: 18px;
        background: #fafcff;
        border-radius: 0 0 16px 16px;
    }

    .toggle-btn {
        cursor: pointer;
        width: 28px;
        color: #2464e0;
        transition: color 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toggle-btn:hover {
        color: #1350b9;
    }

    .round-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        padding: 0;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3em;
        box-shadow: 0 2px 8px 0 rgba(70, 130, 230, .11);
        transition: background 0.18s, box-shadow 0.18s;
    }

    .round-btn:hover {
        background: #387fe7 !important;
        box-shadow: 0 4px 16px 0 rgba(46, 122, 225, 0.16);
        color: #fff !important;
    }
</style>

<script>
    function toggleNode(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const caret = el.parentElement.querySelector('.toggle-btn i');
        if (el.style.display === 'block') {
            el.style.display = 'none';
            if (caret) caret.classList.remove('bi-caret-down-fill'), caret.classList.add('bi-caret-right-fill');
        } else {
            el.style.display = 'block';
            if (caret) caret.classList.remove('bi-caret-right-fill'), caret.classList.add('bi-caret-down-fill');
        }
    }

    function showModalWithForm(formHtml) {
        const modalContent = document.getElementById('formModalContent');
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = formHtml;

        // NEW: For .menu-item-from, print the entire html (minus <html>, <head>, and required attribute for form fields)
        let formContainer = tempDiv.querySelector('.menus-from');
        // If not found, fall back to .menu-item-from and use full HTML minus <html> and <head>
        if (!formContainer) {
            let menuItemForm = tempDiv.querySelector('.menu-item-from');
            if (menuItemForm) {
                // Clone the whole form container to get original html code
                // Remove <header> if present in tempDiv (usually <h2>)
                let formWrapper = menuItemForm.cloneNode(true);
                // Remove any <h2> or <header> tag in clone
                let header = formWrapper.querySelector('h2') || formWrapper.querySelector('header');
                if (header) header.remove();

                // Remove all required attributes from form fields
                let requiredFields = formWrapper.querySelectorAll('[required]');
                requiredFields.forEach(f => f.removeAttribute('required'));

                modalContent.innerHTML = '';
                modalContent.appendChild(formWrapper);
            } else {
                // fallback: just use full HTML if neither found (fail-safe)
                modalContent.innerHTML = '<div class="p-4 bg-danger text-white">Form container with class "menus-from" or "menu-item-from" not found</div>' + formHtml;
            }
        } else {
            // original code path for menus-from class
            formContainer = formContainer.cloneNode(true);
            modalContent.innerHTML = '';
            modalContent.appendChild(formContainer);
        }

        // Add close button if not present after HTML is set
        if (!modalContent.querySelector('[data-bs-dismiss]')) {
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close position-absolute top-0 end-0 m-3';
            closeBtn.setAttribute('data-bs-dismiss', 'modal');
            closeBtn.setAttribute('aria-label', 'Close');
            modalContent.prepend(closeBtn);
        }
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('formModal'));
        modal.show();
        addModalFormListener();
        addModalDynamicEventListeners(); // Attach dynamic features inside modal after showing form
    }

    function reloadNavbarTree() {
        fetch("{{ route('admin.preview.navbar') }}")
            .then(r => r.text())
            .then(html => {
                // Get the html of the #navbarTree from the response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTree = doc.getElementById('navbarTree');
                document.getElementById('navbarTree').innerHTML = newTree ? newTree.innerHTML : '';
                // Optionally close modal if open
                let modalEl = document.getElementById('formModal');
                let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
                // Re-attach handlers after reload
                attachTreeDelegatedHandlers();
            });
    }

    function handleAddMenuClick() {
        fetch("{{ route('admin.menus.create') }}")
            .then(res => res.text())
            .then(formHtml => {
                showModalWithForm(formHtml);
            });
    }

    function handleAddMenuItemClick(menuId) {
        fetch(`{{ route('admin.menu-items.create') }}?menu_id=${menuId}`)
            .then(res => res.text())
            .then(formHtml => {
                showModalWithForm(formHtml);
            });
    }
  // This function adds menu items under the root menu (not a submenu).
    function handleAddMenuItemForMenu(menuId) {
        // Open the modal form for adding a child menu item directly under the given menu
        // Pass parent_type=menu and parent_id=menuId as query params to pre-fill the form
        fetch(`{{ route('admin.menu-items.create') }}?parent_type=menu&parent_id=${menuId}`)
            .then(res => res.text())
            .then(formHtml => {
                if (typeof showModalWithForm === 'function') {
                    showModalWithForm(formHtml);
                } else {
                    // Fallback: open in new window or alert
                    const newWin = window.open('', '_blank');
                    newWin.document.write(formHtml);
                }
            });
    }
    function handleAddMenuItemWithParams(parentMenuItemId) {
        // Open the modal form for adding a child menu item under the given menu item
        // Pass parent_type=menu_item and parent_id=parentMenuItemId as query params to pre-fill the form
        fetch(`{{ route('admin.menu-items.create') }}?parent_type=menu_item&parent_id=${parentMenuItemId}`)
            .then(res => res.text())
            .then(formHtml => {
                if (typeof showModalWithForm === 'function') {
                    showModalWithForm(formHtml);
                } else {
                    // Fallback: open in new window or alert
                    const newWin = window.open('', '_blank');
                    newWin.document.write(formHtml);
                }
            });
    }
    
    function handleEditMenuClick(menuId) {
        fetch(`{{ url('admin/menus/${menuId}/edit') }}`.replace('${menuId}', menuId))
            .then(res => res.text())
            .then(formHtml => {
                showModalWithForm(formHtml);
            });
    }

    function handleEditMenuitemsClick(menuId) {
        fetch(`{{ url('admin/menu-items/${menuId}/edit') }}`.replace('${menuId}', menuId))
            .then(res => res.text())
            .then(formHtml => {
                showModalWithForm(formHtml);
            });
    }

    function handleDeleteMenuClick(menuId) {
        // Placeholder for delete logic (confirmation & AJAX delete if you have API)
        if (confirm("Are you sure you want to delete this menu?")) {
            fetch(`{{ url('admin/menus/') }}/${menuId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(resp => {
                    if (resp.success) {
                        reloadNavbarTree();
                    } else {
                        alert('Failed to delete.');
                    }
                }).catch(() => {
                    alert('Failed to delete.');
                });
        }
    }

    function handleDeleteMenuitemsClick(menuItemId) {
        if (confirm("Are you sure you want to delete this menu item?")) {
            fetch(`{{ url('admin/menu-items/') }}/${menuItemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(resp => {
                    if (resp.success) {
                        reloadNavbarTree();
                    } else {
                        alert('Failed to delete menu item.');
                    }
                }).catch(() => {
                    alert('Failed to delete menu item.');
                });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-expand first menu for demonstration
        const firstTree = document.querySelector('.node-children');
        if (firstTree) {
            firstTree.style.display = 'block';
            const caret = firstTree.parentElement.querySelector('.toggle-btn i');
            if (caret) caret.classList.remove('bi-caret-right-fill'), caret.classList.add('bi-caret-down-fill');
        }
        // No need to bind addMenuBtn here since onclick inline on button now
        attachTreeDelegatedHandlers();
    });

    // Handler for dynamic elements inside #navbarTree (and re-applied after effects)
    function attachTreeDelegatedHandlers() {
        // All click handling now via inline onclick, no longer needed here
        // unless you have elements not handled via inline onclick.
    }

    // Attach JS features to modal forms every time a modal is opened
    function addModalDynamicEventListeners() {
        const modalContent = document.getElementById('formModalContent');
        if (!modalContent) return;

        modalContent.addEventListener('click', function(e) {
            // You can extend here to cover more UI JS as needed for modal forms
        });

        // You can add more delegated JS for modal forms here (e.g. validation, toggles)
    }

    function addModalFormListener() {
        setTimeout(function() {
            const modalContent = document.getElementById('formModalContent');
            // Find close/cancel buttons
            const cancelBtn = modalContent.querySelector('.btn-cancel, .btn-secondary, [data-bs-dismiss="modal"]');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function(e) {
                    let modalEl = document.getElementById('formModal');
                    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.hide();
                });
            }
            // Intercept submit and handle via AJAX, then reload the tree
            const form = modalContent.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const fd = new FormData(form);
                    fetch(form.action, {
                            method: form.method,
                            body: fd,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(r => r.json())
                        .then(resp => {
                            if (resp.success) {
                                reloadNavbarTree();
                            } else if (resp.html) { // on validation error, update form inside modal
                                showModalWithForm(resp.html);
                            }
                        }).catch(() => {}); // silent error
                });
            }
        }, 200);
    }
</script>


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

<!-- Add Bootstrap and Bootstrap Icons CDN if not already included -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>