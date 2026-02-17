<div class="tree-node position-relative" style="--tree-node-padding: 0.25rem 0 0.25rem 0.8rem;">

    <div class="node-row d-flex align-items-center justify-content-between px-1" style="padding: var(--tree-node-padding); position: relative;">

        <div class="d-flex align-items-center gap-2">
            @if($item->childrenRecursive->count())
            <span class="toggle-btn"
                onclick="toggleNode('item-{{ $item->id }}')" style="cursor:pointer;">
                <i class="bi bi-caret-right-fill"></i>
            </span>
            @else
            <span style="width:18px;"></span>
            @endif
            <span>{{ $item->title }}</span>
            <div class="ms-2 tree-node-actions d-none">
                <button
                    class="btn btn-light shadow-sm edit-menu-btn"
                    onclick="handleEditMenuitemsClick({{ $item->id }})"
                    title="Edit"
                    style="padding:.2em .55em; border-radius: 50%; border:none; color:#295ccb;">
                    <i class="bi bi-pencil"></i>
                </button>
                <button
                    class="btn btn-light shadow-sm delete-menu-btn ms-1"
                    onclick="handleDeleteMenuitemsClick({{ $item->id }})"
                    title="Delete"
                    style="padding:.2em .55em; border-radius: 50%; border:none; color:#dc3545;">
                    <i class="bi bi-trash"></i>
                </button>
                {{-- Add child menu item (plus button) --}}
                <button
                    class="btn btn-light shadow-sm add-menu-btn ms-1"
                    onclick="event.stopPropagation(); handleAddMenuItemWithParams({{ $item->id }})"
                    title="Add Child Menu Item"
                    style="padding:.2em .55em; border-radius: 50%; border:none; color:#22c55e;">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>

    </div>

    @if($item->childrenRecursive->count())
    <div id="item-{{ $item->id }}" class="node-children" style="margin-left:1.7em;">
        @foreach($item->childrenRecursive as $child)
        @include('admin.preview.tree-node', [
        'item' => $child
        ])
        @endforeach
    </div>
    @endif

</div>
<style>
    .tree-node:hover>.node-row .tree-node-actions {
        display: inline-block !important;
    }

    .tree-node-actions {
        transition: opacity 0.15s;
    }
</style>