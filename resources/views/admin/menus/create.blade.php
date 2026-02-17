@extends('admin.layouts.app')

@php
$backUrl = route('admin.menus.index');
$backTitle = "Menus";
$formMode = $formMode ?? (isset($item) && $item->exists ? 'edit' : 'create');
@endphp

@section('content')

<div class="menus-from" style="max-width: 420px; margin: 2rem auto; background: #fcfcfc; border-radius: 10px; box-shadow: 0 2px 8px #ececec; padding: 32px 26px;">
    <h2 style="text-align: center; margin-bottom: 1.7rem; letter-spacing:1px;">{{ $formMode == 'edit' ? 'Edit Menu' : 'Create Menu' }}</h2>
    <form method="POST"
        action="{{ $formMode == 'edit'
                            ? route('admin.menus.update', $menu->id)
                            : route('admin.menus.store') }}">
        @csrf
        @if($formMode == 'edit')
        @method('PUT')
        @endif

        <div style="margin-bottom: 1.3em;">
            <label for="title" style="display: block; font-weight: bold;">Menu Title</label>
            <input id="title" type="text"
                name="title"
                class="form-control"
                style="width:100%;padding:7px;"
                maxlength="100"
                value="{{ old('title', $menu->title ?? '') }}" required>
            @error('title')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1.3em;">
            <label for="description" style="display: block; font-weight: bold;">Description</label>
            <input id="description"
                name="description"
                class="form-control"
                style="width:100%;padding:7px;"
                rows="2">{{ old('description', $menu->description ?? '') }}</textarea>
            @error('description')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

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
                <option value="{{ $faClass }}" {{ old('icon', $menu->icon ?? '') == $faClass ? 'selected' : '' }}>
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
                value="{{ old('icon', $menu->icon ?? '') }}"
                placeholder="Or enter custom FontAwesome class">
            <small style="font-size:0.97em;color:#777;">You may pick from the dropdown or enter your own icon class.</small>
            @error('icon')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>
        <script>
            // Keep select and text input in sync
            document.addEventListener('DOMContentLoaded', function() {
                const iconInput = document.getElementById('icon');
                const iconSelect = document.getElementById('icon_select');
                // When icon textbox changes, update dropdown selection if value found
                iconInput.addEventListener('input', function() {
                    let found = false;
                    for (let o of iconSelect.options) {
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

        <div style="margin-bottom: 1.3em;">
            <label for="sort_order" style="display: block; font-weight: bold;">Sort Order</label>
            <input id="sort_order" type="number"
                name="sort_order"
                class="form-control"
                style="width:100%;padding:7px;"
                value="{{ old('sort_order', $menu->sort_order ?? '') }}">
            @error('sort_order')
            <div style="color: #d33; font-size: 0.97em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1.5em;">
            <label for="status" style="display: block; font-weight: bold;">Status</label>
            <select name="status" id="status"
                class="form-control"
                style="width:100%;padding:7px 10px;"
                required>
                <option value="" disabled {{ old('status', $menu->status ?? 'active') == null ? 'selected' : '' }}>Select Status</option>
                <option value="active"
                    {{ (old('status', $menu->status ?? 'active') == 'active') ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive"
                    {{ (old('status', $menu->status ?? 'active') == 'inactive') ? 'selected' : '' }}>
                    Inactive
                </option>
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
                {{ $formMode == 'edit' ? 'Update Menu' : 'Create Menu' }}
            </button>
        </div>
    </form>
</div>
@endsection