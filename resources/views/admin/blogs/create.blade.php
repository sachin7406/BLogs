@extends('admin.layouts.app')

@section('content')

@php
/** @var \App\Models\Blog|null $blog */
$isEdit = isset($blog) && $blog;
@endphp

@if ($isEdit && $blog)
<textarea id="initialBlogContent" style="display:none;">{{ $blog->content }}</textarea>
@endif
<style>
    /**
     * BLOG EDITOR STYLES - SECTIONS (use Ctrl+F to jump)
     * ----------------------------------------
     * RESET, BASE
     * TOP BAR - wp-topbar, wp-logo, plus button, command palette
     * DASHBOARD MENU, LIST VIEW PANEL
     * COMMAND PALETTE MODAL
     * PREVIEW MODAL
     * LAYOUT - wp-layout, sidebar-collapsed
     * LEFT PANEL - wp-left, wp-left-tabs, block-category, block-item, text-blocks-grid
     * CENTER - editor-wrapper, editor-title, editor-placeholder, editor-add-block-btn, floating-inserter
     * BLOCKS - .block, block-controls, block-drag-handle, columns, column
     * RIGHT PANEL - wp-right, settings-tabs, settings-group, featured-image, heading-level-btns, block-inspector
     * SLASH MENU, BLOCK TOOLBAR, BLOCK TOOLBAR MORE
     * COLUMN LAYOUT MODAL, IMAGE BLOCK, ACCORDION, QUOTE, CODE, LIST, SEPARATOR, SPACER, BUTTONS
     */
    /* ================= RESET ================= */
    * {
        box-sizing: border-box;
    }

    /* ================= BASE ================= */
    html,
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
    }

    body {
        background: #f0f0f1;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, Oxygen, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        color: #1e1e1e;
    }

    /* ================= TOP BAR ================= */
    .wp-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 56px;
        padding: 0 16px;
        background: #ffffff;
        border-bottom: 1px solid #dcdcde;
        position: relative;
        z-index: 100;
    }

    .wp-topbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .wp-topbar-center {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        justify-content: center;
    }

    .wp-topbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .wp-topbar .icon-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: transparent;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1d2327;
        font-size: 18px;
    }

    .wp-topbar .icon-btn:hover {
        background: #f6f7f7;
    }

    .wp-topbar .icon-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .wp-topbar .post-name {
        font-size: 14px;
        color: #1d2327;
        cursor: pointer;
        padding: 6px 12px;
        border-radius: 4px;
    }

    .wp-topbar .post-name:hover {
        background: #f6f7f7;
    }

    .wp-topbar .command-palette {
        font-size: 12px;
        color: #50575e;
        padding: 4px 8px;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        background: #f6f7f7;
        cursor: pointer;
    }

    .wp-topbar .command-palette:hover {
        background: #e5e5e5;
    }

    .wp-topbar .actions button {
        margin-left: 8px;
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 4px;
        border: 1px solid #dcdcde;
        background: #ffffff;
        color: #1d2327;
        cursor: pointer;
    }

    .wp-topbar .actions button:hover {
        background: #f6f7f7;
    }

    .wp-topbar .actions .publish {
        background: #3858e9;
        color: #fff;
        border-color: #3858e9;
    }

    .wp-topbar .actions .publish:hover {
        background: #2f4ad9;
    }

    /* Command Palette Modal */
    .command-palette-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }

    .command-palette-modal.show {
        display: flex;
    }

    .command-palette-content {
        background: #ffffff;
        width: 600px;
        max-height: 70vh;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .command-palette-input {
        width: 100%;
        padding: 16px;
        font-size: 16px;
        border: none;
        border-bottom: 1px solid #dcdcde;
        outline: none;
    }

    .command-palette-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .command-palette-item {
        padding: 12px 16px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f1;
    }

    .command-palette-item:hover,
    .command-palette-item.selected {
        background: #f6f7f7;
    }

    /* Preview Modal */
    .preview-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ffffff;
        z-index: 10000;
        display: none;
        flex-direction: column;
    }

    .preview-modal.show {
        display: flex;
    }

    .preview-header {
        padding: 16px;
        border-bottom: 1px solid #dcdcde;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .preview-device {
        display: flex;
        gap: 8px;
    }

    .preview-device button {
        padding: 6px 12px;
        border: 1px solid #dcdcde;
        background: #ffffff;
        border-radius: 4px;
        cursor: pointer;
    }

    .preview-device button.active {
        background: #3858e9;
        color: #fff;
        border-color: #3858e9;
    }

    .preview-content {
        flex: 1;
        overflow: auto;
        padding: 40px;
        background: #f6f7f7;
    }

    .preview-frame {
        max-width: 100%;
        margin: 0 auto;
        background: #ffffff;
        padding: 40px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .preview-frame.desktop {
        max-width: 1200px;
    }

    .preview-frame.tablet {
        max-width: 768px;
    }

    .preview-frame.mobile {
        max-width: 375px;
    }
</style>
<!-- =========left -->
<style>
    /* .wp-layout start left ======================================= */
    /* ================= LAYOUT ================= */
    .wp-layout {
        display: grid;
        grid-template-columns: 280px 1fr 320px;
        height: calc(100vh - 56px);
        overflow: hidden;
        width: 100%;
        max-width: 100vw;
    }

    /* ================= LEFT PANEL (ref: image 1, 2) ================= */
    .wp-left {
        background: #ffffff;
        border-right: 1px solid #dcdcde;
        padding: 0;
        overflow-y: auto;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
        width: 280px;
        min-width: 280px;
    }

    .wp-left-tabs {
        display: flex;
        border-bottom: 1px solid #dcdcde;
        padding: 0 16px;
    }

    .wp-left-tab {
        padding: 12px 16px;
        border: none;
        background: none;
        font-size: 12px;
        color: #50575e;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
    }

    .wp-left-tab:hover {
        color: #1d2327;
    }

    .wp-left-tab.active {
        color: #1d2327;
        font-weight: 600;
        border-bottom-color: #3858e9;
    }

    .wp-left-tab-content {
        padding: 16px;
        flex: 1;
        overflow-y: auto;
    }

    .wp-left-placeholder {
        font-size: 12px;
        color: #50575e;
        margin: 0;
    }

    .wp-left .wp-left-search {
        margin: 12px 16px;
        width: calc(100% - 32px);
    }

    .wp-left input.wp-left-search {
        width: 100%;
        padding: 8px 10px;
        font-size: 13px;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .wp-left h6 {
        font-size: 11px;
        color: #50575e;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .wp-left ul {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
    }

    .wp-left li {
        font-size: 12px;
        padding: 6px 8px;
        border-radius: 4px;
        cursor: pointer;
    }

    .wp-left li:hover {
        background: #f6f7f7;
    }

    /* Left view panel */
    /* Left panel - hierarchical List View (Gutenberg-like) */
    .wp-left-listview {
        border-bottom: 1px solid #dcdcde;
        max-height: 220px;
        overflow-y: auto;
        padding: 8px 12px;
        font-size: 13px;
    }

    /* List View panel (ref: image 7) - toggled by hamburger */
    .list-view-panel {
        width: 100%;
        background: #fff;
        border-bottom: 1px solid #dcdcde;
        display: none;
        flex-direction: column;
    }

    /* visible when toggled via List View button */
    .list-view-panel.show {
        display: flex;
    }

    .list-view-panel .lv-tabs {
        display: flex;
        border-bottom: 1px solid #dcdcde;
        padding: 0 12px;
    }

    .list-view-panel .lv-tabs button {
        padding: 12px 16px;
        border: none;
        background: none;
        font-size: 13px;
        color: #50575e;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
    }

    .list-view-panel .lv-tabs button.active {
        color: #1d2327;
        font-weight: 600;
        border-bottom-color: #3858e9;
    }

    .list-view-panel .lv-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
    }

    .list-view-panel .lv-close {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        color: #50575e;
        font-size: 18px;
    }

    .list-view-panel .lv-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px 0;
    }

    .list-view-panel .lv-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        font-size: 13px;
        color: #1d2327;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .list-view-panel .lv-item:hover {
        background: #f6f7f7;
    }

    .list-view-panel .lv-item.selected {
        background: #3858e9;
        color: #fff;
    }

    .list-view-panel .lv-item .lv-item-more {
        opacity: 0;
        padding: 2px;
        border: none;
        background: none;
        cursor: pointer;
        color: inherit;
    }

    .list-view-panel .lv-item:hover .lv-item-more,
    .list-view-panel .lv-item.selected .lv-item-more {
        opacity: 1;
    }
</style>
<!-- ========center -->
<style>
    /* ================= CENTER ================= */
    .wp-center {
        background: #f6f7f7;
        overflow-y: auto;
        overflow-x: hidden;
        width: 100%;
    }

    .editor-wrapper {
        max-width: 840px;
        margin: 20px auto;
        background: #ffffff;
        padding: 20px 72px;
        position: relative;
        min-height: calc(100vh - 56px);
        box-sizing: border-box;
    }

    /* Floating "Add block" + button (ref: image 3, 4) - right of content */
    .editor-add-block-btn {
        position: absolute;
        right: -0;
        top: 120px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #1d2327;
        color: #fff;
        border: none;
        cursor: pointer;
        display: none;
        /* Shown only when editor is empty */
        align-items: center;
        justify-content: center;
        font-size: 15px;
        line-height: 1;
        z-index: 10;
    }

    .editor-add-block-btn:hover {
        background: #3858e9;
    }

    /* Floating block inserter popup (ref: image 4) */
    .floating-inserter {
        position: absolute;
        background: #fff;
        border: 1px solid #dcdcde;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        min-width: 320px;
        max-width: 400px;
        z-index: 1000;
        display: none;
        flex-direction: column;
        max-height: 70vh;
    }

    .floating-inserter.show {
        display: flex;
    }

    .floating-inserter .fi-search {
        padding: 12px;
        border-bottom: 1px solid #dcdcde;
    }

    .floating-inserter .fi-search input {
        width: 100%;
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #dcdcde;
        border-radius: 4px;
    }

    .floating-inserter .fi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        overflow-y: auto;
    }

    .floating-inserter .fi-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 6px 8px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 10px;
        color: #1d2327;
        border: 1px solid transparent;
    }

    .floating-inserter .fi-item:hover {
        background: #f6f7f7;
        border-color: #dcdcde;
    }

    .floating-inserter .fi-item-icon {
        font-size: 18px;
        margin-bottom: 4px;
    }

    .floating-inserter .fi-browse {
        padding: 12px;
        border-top: 1px solid #dcdcde;
    }

    .floating-inserter .fi-browse button {
        width: 100%;
        padding: 10px;
        background: #1d2327;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }


    /* Title */
    .editor-title {
        width: 100%;
        font-size: 42px;
        font-weight: 300;
        line-height: 1.2;
        border: none;
        outline: none;
        color: #949494;
        margin-bottom: 48px;
        padding: 0;
    }

    .editor-title:focus {
        color: #1d2327;
    }

    .editor-title::placeholder {
        color: #949494;
    }


    .editor-title::placeholder {
        color: #949494;
    }

    /* ================= BLOCKS ================= */
    .block {
        position: relative;
        margin-bottom: 14px;
        padding: 6px;
        border-radius: 2px;
        cursor: move;
        transition: all 0.2s;
    }

    .block:hover {
        outline: 1px solid #dcdcde;
    }

    .block:focus-within {
        outline: 2px solid #3858e9;
    }

    .block.dragging {
        opacity: 0.5;
        outline: 2px dashed #3858e9;
    }

    .block.drag-over {
        outline: 2px solid #3858e9;
        background: #f0f4ff;
    }

    .block-controls {
        position: absolute;
        left: -42px;
        top: 6px;
        display: none;
    }

    .block:focus-within .block-controls,
    .block.selected .block-controls {
        display: block;
    }

    .block-controls button {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #dcdcde;
        background: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transform: rotate(45deg);
    }

    .block-controls button:hover {
        background: #f6f7f7;
    }

    .block-drag-handle {
        position: absolute;
        left: -42px;
        top: 6px;
        width: 30px;
        height: 30px;
        cursor: move;
        display: none;
        align-items: center;
        justify-content: center;
        color: #50575e;
    }

    .block:focus-within .block-drag-handle,
    .block.selected .block-drag-handle {
        display: block;
    }


    .block h1,
    .block h2,
    .block h3,
    .block h4 {
        font-weight: 600;
        color: #1d2327;
        line-height: 1.3;
        margin: 24px 0 12px;
    }

    .block h2 {
        font-size: 32px;
    }

    .block h3 {
        font-size: 28px;
    }

    .block div[contenteditable] {
        font-size: 16px;
        line-height: 1.8;
        color: #1e1e1e;
        margin: 12px 0;
    }


    /* Editable text */
    .block [contenteditable] {
        outline: none;
        min-height: 24px;
        font-size: 16px;
        line-height: 1.6;
    }

    .block [contenteditable]:empty:before {
        content: attr(data-placeholder);
        color: #949494;
        pointer-events: none;
    }

    .block [contenteditable]:focus {
        outline: none;
    }

    /* ================= COLUMNS ================= */
    .columns {
        display: grid;
        gap: 24px;
    }

    .columns[data-cols="1"] {
        grid-template-columns: 1fr;
    }

    .columns[data-cols="2"] {
        grid-template-columns: 1fr 1fr;
    }

    .columns[data-ratio="33-66"] {
        grid-template-columns: 1fr 2fr;
    }

    .columns[data-ratio="66-33"] {
        grid-template-columns: 2fr 1fr;
    }

    .columns[data-cols="3"] {
        grid-template-columns: repeat(3, 1fr);
    }

    .columns[data-ratio="25-50-25"] {
        grid-template-columns: 1fr 2fr 1fr;
    }

    .column {
        min-height: 40px;
        padding: 12px;
        border-radius: 2px;
        border: 1px dashed transparent;
        position: relative;
    }

    .column:hover {
        border-color: #dcdcde;
    }

    .column:empty::before {
        content: 'Drop blocks here';
        color: #949494;
        font-size: 13px;
        pointer-events: none;
    }

    .column .block {
        margin-bottom: 8px;
    }

    /* Insertion marker between blocks (hover + button) */
    .block-insert-marker {
        position: relative;
        height: 12px;
        margin: 2px 0;
    }

    .block-insert-line {
        position: absolute;
        left: 0;
        right: 40px;
        top: 50%;
        height: 1px;
        background: #3858e9;
    }

    .block-insert-plus {
        margin: 0 12px;
        background: #fff;
        border: 2px solid #366be9;
        color: #3658e8;
        font-size: 12px;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(53, 104, 226, 0.09);
        position: relative;
        z-index: 2;
    }

    /* Bottom insertion marker inside a block, shown on hover */
    .block-insert-marker-bottom {
        margin-top: 8px;
        opacity: 0;
        transition: opacity 0.15s ease;
    }

    .block:hover .block-insert-marker-bottom {
        opacity: 1;
    }
</style>
<!-- ==============right/ -->
<style>
    /* ================= RIGHT PANEL ================= */
    .wp-right {
        background: #ffffff;
        border-left: 1px solid #dcdcde;
        padding: 16px;
        font-size: 13px;
        color: #1d2327;
        overflow-y: auto;
        overflow-x: hidden;
        width: 320px;
        min-width: 320px;
    }

    .settings-tabs {
        display: flex;
        border-bottom: 1px solid #dcdcde;
        margin-bottom: 16px;
    }

    .settings-tabs button {
        flex: 1;
        padding: 10px;
        border: none;
        background: none;
        font-size: 13px;
        cursor: pointer;
        color: #50575e;
    }

    .settings-tabs button.active {
        color: #1d2327;
        border-bottom: 2px solid #3858e9;
        font-weight: 600;
    }

    .settings-group {
        margin-bottom: 16px;
    }

    .settings-group strong {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .settings-group .value {
        color: #3858e9;
        cursor: pointer;
    }

    .settings-group .value:hover {
        text-decoration: underline;
    }

    .heading-level-btns .heading-level-btn {
        padding: 6px 12px;
        border: 1px solid #dcdcde;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    .heading-level-btns .heading-level-btn:hover {
        border-color: #3858e9;
        background: #f0f4ff;
    }

    .heading-level-btns .heading-level-btn.active {
        border-color: #1d2327;
        background: #f6f7f7;
        font-weight: 600;
    }

    .block-inspector-desc {
        font-size: 12px;
        color: #50575e;
        margin: 4px 0 12px;
        line-height: 1.4;
    }

    .settings-sub label {
        display: block;
        font-size: 11px;
        color: #50575e;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .collapsible-toggle {
        cursor: pointer;
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .collapsible-toggle::after {
        content: '▸';
        font-size: 14px;
        color: #50575e;
        transition: transform 0.15s ease-in-out;
    }

    .collapsible-toggle.expanded::after {
        /* content: '−'; */
        transform: rotate(90deg);
    }

    .collapsible-content {
        margin-top: 8px;
    }

    /* Block settings – Dimensions/Border like image 1 (sliders + link icon) */
    .block-settings-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .block-settings-header .collapsible-toggle {
        flex: 1;
    }

    .block-settings-kebab {
        border: none;
        background: none;
        cursor: pointer;
        padding: 4px;
        color: #50575e;
        font-size: 16px;
    }

    .block-settings-slider-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
    }

    .block-settings-slider-row label {
        font-size: 11px;
        color: #50575e;
        text-transform: uppercase;
        margin: 0;
        min-width: 52px;
    }

    .block-settings-slider-row input[type="range"] {
        flex: 1;
        height: 6px;
        -webkit-appearance: none;
        appearance: none;
        background: repeating-linear-gradient(90deg, #dcdcde 0, #dcdcde 2px, transparent 2px, transparent 6px);
        border-radius: 3px;
    }

    .block-settings-slider-row input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #3858e9;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .block-settings-slider-row input[type="text"].block-settings-px {
        width: 52px;
        padding: 6px 8px;
        font-size: 12px;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        text-align: right;
    }

    .block-settings-link-icon {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #50575e;
        font-size: 14px;
        cursor: pointer;
    }

    .block-settings-attr-row {
        margin-top: 8px;
    }

    .block-settings-attr-row strong {
        display: block;
        font-size: 13px;
    }

    .block-settings-attr-row .attr-not-connected {
        font-size: 12px;
        color: #50575e;
        font-weight: normal;
    }

    .block-settings-attr-desc {
        font-size: 12px;
        color: #50575e;
        margin-top: 6px;
        line-height: 1.4;
    }

    .width-btn {
        flex: 1;
        padding: 6px;
        border: 1px solid #dcdcde;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    .width-btn:hover {
        border-color: #3858e9;
        background: #f0f4ff;
    }

    .width-btn.active {
        border-color: #1d2327;
        background: #f6f7f7;
        font-weight: 600;
    }

    .layout-mini-btn {
        padding: 6px 10px;
        border: 1px solid #dcdcde;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
    }

    .layout-mini-btn:hover {
        border-color: #3858e9;
        background: #f0f4ff;
    }

    .layout-mini-btn.active {
        border-color: #3858e9;
        background: #f0f4ff;
    }

    .featured-image {
        width: 100%;
        height: 150px;
        border: 1px dashed #dcdcde;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-bottom: 16px;
        background: #f6f7f7;
    }

    .featured-image:hover {
        border-color: #3858e9;
    }

    .featured-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    .featured-image-placeholder {
        text-align: center;
        color: #50575e;
        font-size: 12px;
    }

    .status-radio {
        display: flex;
        gap: 16px;
        margin-top: 8px;
    }

    .status-radio label {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .publish-timing {
        margin-top: 8px;
    }

    .publish-timing input {
        width: 100%;
        padding: 6px;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        font-size: 13px;
    }

    /* Slash Command Menu */
    .slash-menu {
        position: absolute;
        background: #ffffff;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        min-width: 280px;
        display: none;
    }

    .slash-menu.show {
        display: block;
    }

    .slash-menu-item {
        padding: 10px 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #f0f0f1;
    }

    .slash-menu-item:last-child {
        border-bottom: none;
    }

    .slash-menu-item:hover,
    .slash-menu-item.selected {
        background: #f6f7f7;
    }

    .slash-menu-item-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f1;
        border-radius: 4px;
    }

    .slash-menu-item-text {
        flex: 1;
    }

    .slash-menu-item-text strong {
        display: block;
        font-size: 13px;
        color: #1d2327;
    }

    .slash-menu-item-text span {
        display: block;
        font-size: 11px;
        color: #50575e;
        margin-top: 2px;
    }

    /* Top bar: W logo, blue + button (ref: image 1, 7) */
    .wp-topbar .wp-logo {
        width: 36px;
        height: 36px;
        background: #1d2327;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .wp-topbar .icon-btn.plus-toolbar-btn {
        background: transparent;
        color: #1d2327;
    }

    /* Generic active state for topbar icon buttons (plus, settings, etc.) */
    .wp-topbar .icon-btn.active {
        background: #3858e9;
        color: #fff;
    }

    /* Layout when left sidebar collapsed */
    .wp-layout.sidebar-collapsed {
        grid-template-columns: 0 1fr 320px;
    }

    .wp-layout.sidebar-collapsed .wp-left {
        overflow: hidden;
        width: 0;
        padding: 0;
        border: none;
        min-width: 0;
    }

    /* Layout when right settings sidebar collapsed */
    .wp-layout.right-collapsed {
        grid-template-columns: 280px 1fr 0;
    }

    .wp-layout.right-collapsed .wp-right {
        overflow: hidden;
        width: 0;
        min-width: 0;
        padding: 0;
        border: none;
    }

    /* Left panel block items with icons (toolbar style) */
    .block-category {
        margin-bottom: 20px;
    }

    .block-category-title {
        font-size: 11px;
        color: #50575e;
        text-transform: uppercase;
        margin-bottom: 8px;
        padding: 0 4px;
    }

    .block-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        color: #1d2327;
        margin-bottom: 2px;
        user-select: none;
    }

    .block-item:hover {
        background: #f6f7f7;
    }

    .block-item[draggable="true"] {
        cursor: grab;
    }

    .block-item[draggable="true"]:active {
        cursor: grabbing;
    }

    .block-item-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f1;
        border-radius: 4px;
        font-size: 14px;
        flex-shrink: 0;
    }

    .block-item-text {
        flex: 1;
    }

    /* Block floating toolbar (above selected block) */
    .block-toolbar {
        position: absolute;
        background: #ffffff;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: none;
        align-items: center;
        gap: 2px;
        padding: 4px;
        z-index: 500;
        white-space: nowrap;
    }

    .block-toolbar.show {
        display: flex;
    }

    .block-toolbar .tb-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1d2327;
        font-size: 14px;
    }

    .block-toolbar .tb-btn:hover {
        background: #f6f7f7;
    }

    .block-toolbar .tb-btn.active {
        background: #e8eaed;
        color: #3858e9;
    }

    .block-toolbar .tb-divider {
        width: 1px;
        height: 24px;
        background: #dcdcde;
        margin: 0 4px;
    }

    .block-toolbar .tb-select {
        padding: 4px 8px;
        font-size: 13px;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        background: #fff;
        cursor: pointer;
        min-width: 60px;
    }

    .block-toolbar .tb-color {
        width: 28px;
        height: 28px;
        border-radius: 4px;
        border: 1px solid #dcdcde;
        cursor: pointer;
        padding: 0;
    }

    /* Transform To dropdown (ref: image 4) */
    .tb-transform-wrap {
        position: relative;
        display: inline-block;
    }

    .tb-transform-btn {
        min-width: auto !important;
        padding: 4px 8px !important;
        font-size: 13px !important;
        display: inline-flex !important;
        align-items: center;
        gap: 4px;
    }

    .tb-transform-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 4px;
        min-width: 200px;
        background: #fff;
        border: 1px solid #dcdcde;
        border-radius: 6px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.14);
        padding: 6px 0;
        z-index: 1000;
    }

    .tb-transform-dropdown.show {
        display: block;
    }

    .tb-transform-title {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        color: #50575e;
        padding: 6px 14px 8px;
        letter-spacing: 0.05em;
    }

    .tb-transform-option {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 8px 14px;
        border: none;
        background: none;
        font-size: 14px;
        color: #1d2327;
        cursor: pointer;
        text-align: left;
    }

    .tb-transform-option:hover {
        background: #f0f4ff;
        color: #3858e9;
    }

    .tb-transform-option.active {
        background: #f0f4ff;
        color: #3858e9;
    }

    .tb-transform-icon {
        width: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .tb-transform-hr {
        margin: 6px 0;
        border: none;
        border-top: 1px solid #eef1f4;
    }

    .block-toolbar .tb-section {
        display: flex;
        align-items: center;
        gap: 2px;
    }

    /* Block toolbar More dropdown (ref: image 5) */
    .block-toolbar-more {
        position: absolute;
        top: 0;
        left: 0;
        background: #fff;
        border: 1px solid #dcdcde;
        border-radius: 6px;
        box-shadow: 0 6px 24px 0 rgba(0, 0, 0, 0.14);
        min-width: 220px;
        padding: 6px 0;
        display: none;
        z-index: 1000;
        transition: box-shadow 0.15s, opacity 0.12s;
        user-select: none;
        opacity: 0;
        pointer-events: none;
    }

    .block-toolbar-more.show {
        display: block;
        opacity: 1;
        pointer-events: auto;
        animation: dropdownIn 0.12s cubic-bezier(0.65, 0, 0.35, 1);
    }

    @keyframes dropdownIn {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .block-toolbar-more button {
        display: block;
        width: 100%;
        padding: 10px 18px;
        border: none;
        background: transparent;
        text-align: left;
        font-size: 14px;
        color: #262a2e;
        cursor: pointer;
        border-radius: 0;
        transition: background 0.13s, color 0.13s;
    }

    .block-toolbar-more button:hover,
    .block-toolbar-more button:focus {
        background-color: #f0f4ff;
        color: #354fd7;
        outline: none;
    }

    .block-toolbar-more hr {
        margin: 7px 0;
        border: 0;
        border-top: 1px solid #eef1f4;
        height: 0;
    }

    .editor-placeholder {
        color: #949494;
        font-size: 16px;
        margin: 0 0 24px;
        pointer-events: none;
    }

    /* Column layout picker */
    .column-layout-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10001;
    }

    .column-layout-modal.show {
        display: flex;
    }

    .column-layout-content {
        background: #fff;
        padding: 24px;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        max-width: 400px;
    }

    .column-layout-content h3 {
        margin: 0 0 8px;
        font-size: 16px;
    }

    .column-layout-content p {
        margin: 0 0 16px;
        font-size: 13px;
        color: #50575e;
    }

    .column-layout-options {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .column-layout-options button {
        padding: 10px 16px;
        border: 1px solid #dcdcde;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .column-layout-options button:hover {
        border-color: #3858e9;
        background: #f0f4ff;
    }

    .column-layout-options button .cols-visual {
        display: flex;
        gap: 2px;
    }

    .column-layout-options button .cols-visual span {
        width: 8px;
        height: 20px;
        background: #dcdcde;
        border-radius: 1px;
    }

    .column-layout-content .skip-link {
        display: inline-block;
        margin-top: 12px;
        color: #3858e9;
        font-size: 13px;
        cursor: pointer;
    }

    /* Image block in editor */
    .block-image-inner {
        border: 2px dashed #dcdcde;
        border-radius: 8px;
        padding: 24px;
        background: #f6f7f7;
        min-height: 120px;
    }

    .block-image-inner.has-image {
        border-style: solid;
        padding: 8px;
        background: #fff;
        display: inline-block;
        max-width: 100%;
        resize: both;
        overflow: auto;
    }

    .block-image-inner.has-image img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    .block-image-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .block-image-actions .btn-upload {
        background: #3858e9;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    .block-image-actions .btn-secondary {
        background: #fff;
        color: #3858e9;
        border: 1px solid #3858e9;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    .block-image-actions .btn-secondary:hover {
        background: #f0f4ff;
    }

    .block-image-instruction {
        font-size: 13px;
        color: #50575e;
        margin-bottom: 12px;
    }


    /* Accordion block */
    .block-accordion-item {
        border: 1px solid #dcdcde;
        border-radius: 4px;
        margin-bottom: 8px;
        overflow: hidden;
    }

    .block-accordion-title {
        padding: 12px 16px;
        background: #f6f7f7;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .block-accordion-title .accordion-toggle {
        font-size: 18px;
        font-weight: bold;
        color: #50575e;
        margin-left: 8px;
    }

    .block-accordion-body {
        padding: 12px 16px;
        border-top: 1px solid #dcdcde;
    }

    .block-accordion-body [contenteditable] {
        min-height: 24px;
    }

    /* Quote block */
    .block blockquote {
        margin: 12px 0;
        padding: 12px 20px;
        border-left: 4px solid #3858e9;
        background: #f6f7f7;
        color: #1d2327;
        font-style: italic;
    }

    /* Code block */
    .block pre.code-block {
        margin: 12px 0;
        padding: 16px;
        background: #1e1e1e;
        color: #e0e0e0;
        border-radius: 4px;
        font-family: monospace;
        font-size: 13px;
        overflow-x: auto;
    }

    /* List block */
    .block ul.block-list,
    .block ol.block-list {
        margin: 12px 0;
        padding-left: 24px;
    }

    .block ul.block-list li,
    .block ol.block-list li {
        margin: 4px 0;
    }

    /* Hidden / locked block states (used by toolbar “More”) */
    .block.is-hidden {
        display: none !important;
    }

    .block[data-locked="1"] [contenteditable],
    .block[data-locked="1"] .block-controls,
    .block[data-locked="1"] .block-drag-handle {
        pointer-events: none;
        opacity: 0.6;
    }

    /* Separator / Spacer */
    .block-separator {
        height: 1px;
        background: #dcdcde;
        margin: 16px 0;
    }

    .block-spacer {
        height: 40px;
        margin: 0;
    }

    /* Buttons block */
    .block-buttons-inner {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding: 8px 0;
    }

    .block-buttons-inner .btn-inline {
        padding: 8px 16px;
        border-radius: 4px;
        border: 1px solid #dcdcde;
        background: #f6f7f7;
        cursor: pointer;
        font-size: 14px;
    }

    .block-buttons-inner .btn-inline.primary {
        background: #3858e9;
        color: #fff;
        border-color: #3858e9;
    }
</style>

<!-- ================= TOP BAR (ref: image 1, 7) ================= -->
<div class="wp-topbar">
    <div class="wp-topbar-left">
        <button class="icon-btn plus-toolbar-btn active" id="plusToolbarBtn" title="Add block">+</button>
        <button class="icon-btn" id="undoBtn" title="Undo" disabled>↶</button>
        <button class="icon-btn" id="redoBtn" title="Redo" disabled>↷</button>
        <button class="icon-btn" id="listViewBtn" title="List View">☰</button>
    </div>
    <div class="wp-topbar-center">
        <span class="post-name" id="postName">No title • Post</span>
        <span class="command-palette" id="commandPaletteBtn">Ctrl+K</span>
    </div>
    <div class="wp-topbar-right">
        <button class="icon-btn active" id="settingsSidebarBtn" title="Toggle settings sidebar" style="font-size: 18px; background: #f3f5ff; border-radius: 6px; margin-right: 8px; padding: 7px 13px; border: 1px solid #dde3fa; color: #3858e9; box-shadow: 0 1px 3px rgba(56,88,233,0.07); transition: background 0.2s, box-shadow 0.2s;">
            <span style="font-size: 20px; vertical-align: middle;">⚙</span>
        </button>
        <button class="icon-btn" id="previewBtn" title="Preview" style="font-size: 18px; background: #f8f8fa; border-radius: 6px; margin-right: 8px; padding: 7px 13px; border: 1px solid #eee; color: #333; transition: background 0.2s, box-shadow 0.2s;">
            <span style="font-size: 18px; vertical-align: middle;">👁</span>
        </button>
        <button class="publish" id="publishBtn" style="background: linear-gradient(90deg, #3656ec 0%, #3e9aff 100%); border-radius: 6px; color: #fff; border: none; padding: 8px 22px; font-size: 16px; font-weight: 600; letter-spacing: 0.03em; box-shadow: 0 2px 8px rgba(56,88,233,0.10); transition: background 0.2s, box-shadow 0.2s; cursor: pointer;">
            Publish
        </button>
    </div>
</div>

<!-- Command Palette Modal -->
<div class="command-palette-modal" id="commandPaletteModal">
    <div class="command-palette-content" onclick="event.stopPropagation()">
        <input type="text" class="command-palette-input" id="commandPaletteInput" placeholder="Search or type a command...">
        <div class="command-palette-list">
            <div class="command-palette-item">Add Paragraph</div>
            <div class="command-palette-item">Add Heading</div>
            <div class="command-palette-item">Add List</div>
            <div class="command-palette-item">Add Quote</div>
            <div class="command-palette-item">Add Code</div>
            <div class="command-palette-item">Add Image</div>
            <div class="command-palette-item">Add Columns</div>
            <div class="command-palette-item">Undo</div>
            <div class="command-palette-item">Redo</div>
            <div class="command-palette-item">Save draft</div>
            <div class="command-palette-item">Preview</div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="preview-modal" id="previewModal">
    <div class="preview-header">
        <div class="preview-device">
            <button class="active" data-device="desktop">Desktop</button>
            <button data-device="tablet">Tablet</button>
            <button data-device="mobile">Mobile</button>
        </div>
        <button class="icon-btn" id="closePreviewBtn">✕</button>
    </div>
    <div class="preview-content">
        <div class="preview-frame desktop" id="previewFrame">
            <div id="previewContent"></div>
        </div>
    </div>
</div>

<div class="wp-layout">

    <!-- LEFT - Block inserter (ref: image 1, 2) - INLINE List View + Blocks / Patterns / Media tabs -->
    <div class="wp-left" id="wpLeft">
        <!-- Gutenberg-like List View panel (hierarchical + outline) -->

        <div class="list-view-panel" id="listViewPanel">
            <div class="lv-header">
                <div class="lv-tabs">
                    <button type="button" class="active" data-lv-tab="list">List View</button>
                </div>
                <!-- Close is optional in inline version, keep for parity -->
                <button type="button" class="lv-close" id="listViewClose" title="Close">×</button>
            </div>
            <div class="lv-list" id="listViewList">
                <!-- Filled by JS: flat list view -->
            </div>
        </div>


        <div class="wp-left-tabs">
            <button type="button" class="wp-left-tab active" data-tab="blocks">Blocks</button>
            <button type="button" class="wp-left-tab" data-tab="patterns">Patterns</button>
            <button type="button" class="wp-left-tab" data-tab="media">Media</button>
        </div>
        <input type="text" id="blockSearch" placeholder="Search blocks" class="wp-left-search">

        <div class="wp-left-tab-content" id="wpLeftTabBlocks">
            <div class="block-category">
                <div class="block-category-title ">TEXT</div>
                <div class="block-item" data-block="paragraph" draggable="true" title="Paragraph"><span class="block-item-icon">¶</span><span class="block-item-text">Paragraph</span></div>
                <div class="block-item" data-block="heading" draggable="true" title="Heading"><span class="block-item-icon">🔖</span><span class="block-item-text">Heading</span></div>
                <div class="block-item" data-block="list" draggable="true" title="List"><span class="block-item-icon">≡</span><span class="block-item-text">List</span></div>
                <div class="block-item" data-block="quote" draggable="true" title="Quote"><span class="block-item-icon">"</span><span class="block-item-text">Quote</span></div>
                <div class="block-item" data-block="code" draggable="true" title="Code"><span class="block-item-icon">&lt;/&gt;</span><span class="block-item-text">Code</span></div>
                <div class="block-item" data-block="details" draggable="true" title="Details"><span class="block-item-icon">≡</span><span class="block-item-text">Details</span></div>
                <div class="block-item" data-block="preformatted" draggable="true" title="Preformatted"><span class="block-item-icon">☐</span><span class="block-item-text">Preformatted</span></div>
                <div class="block-item" data-block="table" draggable="true" title="Table" style="background:#f6f8fe;"><span class="block-item-icon" style="color:#4066d7;">🗉</span><span class="block-item-text" style="color:#4066d7;">Table</span></div>
                <div class="block-item" data-block="classic" draggable="true" title="Classic"><span class="block-item-icon">☐</span><span class="block-item-text">Classic</span></div>
            </div>

            <div class="block-category">
                <div class="block-category-title">DESIGN</div>
                <div class="block-item" data-block="accordion" draggable="true" title="Accordion"><span class="block-item-icon">≡</span><span class="block-item-text">Accordion</span></div>
                <div class="block-item" data-block="buttons" draggable="true" title="Buttons"><span class="block-item-icon">▢</span><span class="block-item-text">Buttons</span></div>
                <div class="block-item" data-block="columns" data-cols="picker" draggable="true" title="Columns"><span class="block-item-icon">|||</span><span class="block-item-text">Columns</span></div>
                <div class="block-item" data-block="separator" draggable="true" title="Separator"><span class="block-item-icon">—</span><span class="block-item-text">Separator</span></div>
                <div class="block-item" data-block="spacer" draggable="true" title="Spacer"><span class="block-item-icon">↗</span><span class="block-item-text">Spacer</span></div>
            </div>
            <div class="block-category">
                <div class="block-category-title">MEDIA</div>
                <div class="block-item" data-block="image" draggable="true" title="Image"><span class="block-item-icon">🖼</span><span class="block-item-text">Image</span></div>
            </div>
        </div>
        <div class="wp-left-tab-content" id="wpLeftTabPatterns" style="display:none;">
            <p class="wp-left-placeholder">Patterns coming soon.</p>
        </div>
        <div class="wp-left-tab-content" id="wpLeftTabMedia" style="display:none;">
            <p class="wp-left-placeholder">Media library.</p>
        </div>
    </div>
    <!-- END wp-left (block inserter) -->

    <!-- CENTER: Main editor area -->
    <div class="wp-center">
        <div class="editor-wrapper" id="editorWrapper">
            <input
                class="editor-title"
                id="title"
                placeholder="Add title"
                value="{{ $isEdit ? e($blog->title) : '' }}">
            <div id="editor" class="editor-body"></div>
            <button type="button" class="editor-add-block-btn" id="editorAddBlockBtn" title="Add block">+</button>
            <div class="floating-inserter" id="floatingInserter">
                <div class="fi-search"><input type="text" placeholder="Search" id="floatingInserterSearch"></div>
                <div class="fi-grid" id="floatingInserterGrid"></div>
                <div class="fi-browse"><button type="button" id="floatingInserterBrowseAll">Browse all</button></div>
            </div>
            <div class="slash-menu" id="slashMenu"></div>
            <!-- Block floating toolbar (dynamic based on block type) -->
            <div class="block-toolbar" id="blockToolbar">
                <!-- Text blocks section (ref: image 4 – Transform To dropdown) -->
                <div class="tb-section" id="tbTextSection" style="display:none;">
                    <select class="tb-select" id="tbBlockType" title="Block type" style="display:none;" aria-hidden="true">
                        <option value="paragraph">Paragraph</option>
                        <option value="h1">Heading 1</option>
                        <option value="h2">Heading 2</option>
                        <option value="h3">Heading 3</option>
                        <option value="h4">Heading 4</option>
                        <option value="h5">Heading 5</option>
                        <option value="h6">Heading 6</option>
                        <option value="quote">Quote</option>
                        <option value="code">Code</option>
                        <option value="list">List</option>
                    </select>
                    <div class="tb-transform-wrap">
                        <button type="button" class="tb-btn tb-transform-btn" id="tbTransformBtn" title="Transform to"><span id="tbTransformIcon">¶</span> <span id="tbTransformLabel">Paragraph</span> ▾</button>
                        <div class="tb-transform-dropdown" id="tbTransformDropdown">
                            <div class="tb-transform-title">TRANSFORM TO</div>
                            <button type="button" class="tb-transform-option" data-transform="paragraph"><span class="tb-transform-icon">¶</span> Paragraph</button>
                            <button type="button" class="tb-transform-option" data-transform="h2"><span class="tb-transform-icon">🔖</span> Heading</button>
                            <button type="button" class="tb-transform-option" data-transform="list"><span class="tb-transform-icon">≡</span> List</button>
                            <button type="button" class="tb-transform-option" data-transform="quote"><span class="tb-transform-icon">"</span> Quote</button>
                            <hr class="tb-transform-hr">
                            <button type="button" class="tb-transform-option" data-transform="code"><span class="tb-transform-icon">&lt;/&gt;</span> Code</button>
                            <button type="button" class="tb-transform-option" data-transform="preformatted"><span class="tb-transform-icon">☐</span> Preformatted</button>
                            <button type="button" class="tb-transform-option" data-transform="details"><span class="tb-transform-icon">≡</span> Details</button>
                        </div>
                    </div>
                    <span class="tb-divider"></span>
                    <button type="button" class="tb-btn" id="tbAlignLeft" title="Align left">≡</button>
                    <button type="button" class="tb-btn" id="tbAlignCenter" title="Align center">≡</button>
                    <button type="button" class="tb-btn" id="tbAlignRight" title="Align right">≡</button>
                    <span class="tb-divider"></span>
                    <!-- Move block up/down in the document -->
                    <button type="button" class="tb-btn" id="tbMoveUp" title="Move up">↑</button>
                    <button type="button" class="tb-btn" id="tbMoveDown" title="Move down">↓</button>
                    <span class="tb-divider"></span>
                    <button type="button" class="tb-btn" id="tbBold" title="Bold"><b>B</b></button>
                    <button type="button" class="tb-btn" id="tbItalic" title="Italic"><i>I</i></button>
                    <button type="button" class="tb-btn" id="tbLink" title="Link">🔗</button>
                    <span class="tb-divider"></span>
                    <select class="tb-select" id="tbFontSize" title="Font size">
                        <option value="">Size</option>
                        <option value="12px">Small</option>
                        <option value="16px">Normal</option>
                        <option value="20px">Large</option>
                        <option value="24px">Larger</option>
                    </select>
                    <input type="color" class="tb-color" id="tbColor" value="#1d2327" title="Text color">
                </div>
                <!-- Columns section -->
                <div class="tb-section" id="tbColumnsSection" style="display:none;">
                    <button type="button" class="tb-btn" id="tbColLayout" title="Change layout">Layout</button>
                    <span class="tb-divider"></span>
                    <button type="button" class="tb-btn" id="tbAddCol" title="Add column">+ Column</button>
                </div>
                <!-- Buttons section -->
                <div class="tb-section" id="tbButtonsSection" style="display:none;">
                    <select class="tb-select" id="tbButtonWidth" title="Button width">
                        <option value="25%">25%</option>
                        <option value="50%">50%</option>
                        <option value="75%">75%</option>
                        <option value="100%">100%</option>
                    </select>
                </div>
                <!-- Format section (for text) -->
                <div class="tb-section" id="tbFormatSection" style="display:none;">
                    <span class="tb-divider"></span>
                </div>
                <span class="tb-divider"></span>
                <button type="button" class="tb-btn" id="tbMore" title="More options">⋮</button>
            </div>
            <!-- Block toolbar More dropdown (ref: image 5) -->
            <div class="block-toolbar-more" id="blockToolbarMore">
                <button type="button" data-more="copy">Copy</button>
                <button type="button" data-more="cut">Cut</button>
                <button type="button" data-more="duplicate">Duplicate</button>
                <button type="button" data-more="addBefore">Add before</button>
                <button type="button" data-more="addAfter">Add after</button>
                <hr>
                <button type="button" data-more="addNote">Add note</button>
                <button type="button" data-more="copyStyles">Copy styles</button>
                <button type="button" data-more="pasteStyles">Paste styles</button>
                <button type="button" data-more="lock">Lock</button>
                <button type="button" data-more="rename">Rename</button>
                <button type="button" data-more="hide">Hide</button>
                <button type="button" data-more="createPattern">Create pattern</button>
                <button type="button" data-more="editHtml">Edit as HTML</button>
                <hr>
                <button type="button" data-more="delete">Delete</button>
            </div>
        </div>
    </div>
    <!-- END wp-center -->

    <!-- RIGHT: Post & Block settings -->
    <div class="wp-right">
        <div class="settings-tabs">
            <button class="active" data-tab="post">Post</button>
            <button data-tab="block">Block</button>
        </div>

        <div id="postSettings">
            <div class="settings-group">
                <strong>Featured Image</strong>
                <div class="featured-image" id="featuredImageBtn">
                    <div class="featured-image-placeholder">
                        <div>📷</div>
                        <div>Set featured image</div>
                    </div>
                </div>
                <input type="file" id="featuredImageInput" accept="image/*" style="display: none;">
            </div>

            <div class="settings-group">
                <strong>Last edited</strong>
                <div id="lastEdited">Just now</div>
            </div>

            <div class="settings-group">
                <strong>Status</strong>
                <div class="status-radio">
                    <label>
                        <input type="radio" name="status" value="active"
                            {{ $isEdit ? ($blog->status === 'active' ? 'checked' : '') : 'checked' }}>
                        Active
                    </label>
                    <label>
                        <input type="radio" name="status" value="inactive"
                            {{ $isEdit && $blog->status === 'inactive' ? 'checked' : '' }}>
                        Inactive
                    </label>
                </div>
            </div>

            <div class="settings-group" style="display: none;">
                <strong>Publish</strong>
                <div class="value" id="publishTiming">Immediately</div>
                <div class="publish-timing" id="publishTimingInput" style="display: none;">
                    <input type="datetime-local" id="scheduleDate">
                </div>
            </div>

            <div class="settings-group" style="display: none;">
                <strong>Slug</strong>
                <div class="value" id="slugValue">
                    {{ $isEdit && !empty($blog->slug) ? e($blog->slug) : 'auto-generated' }}
                </div>
                <input
                    type="text"
                    id="slugInput"
                    value="{{ $isEdit && !empty($blog->slug) ? e($blog->slug) : '' }}"
                    style="display: none; width: 100%; padding: 6px; border: 1px solid #dcdcde; border-radius: 4px; margin-top: 6px;">
            </div>

            <div class="settings-group">
                <strong>Author</strong>
                <div class="value" id="authorValue">Admin</div>
                <select id="authorSelect" style="display: none; width: 100%; padding: 6px; border: 1px solid #dcdcde; border-radius: 4px; margin-top: 6px;">
                    <option>Admin</option>
                    <option>Editor</option>
                    <option>Author</option>
                </select>
            </div>
            <div class="settings-group">
                <strong>Category</strong>
                <select id="categorySelect" style="width:100%;padding:6px;border:1px solid #dcdcde;border-radius:4px;margin-top:6px;">
                    <option value="">Uncategorized</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $isEdit && $blog && $blog->category_id === $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <div style="margin-top:6px;font-size:12px;color:#50575e;">Choose a category for this post.</div>
            </div>

            <div class="settings-group">
                <strong>Tags</strong>
                <input type="text" id="tagsInput" placeholder="Add tags (comma separated)" value="{{ $isEdit ? e($blog->tags ?? '') : '' }}" style="width:100%;padding:6px;border:1px solid #dcdcde;border-radius:4px;margin-top:6px;">
                <div style="margin-top:6px;font-size:12px;color:#50575e;">Separate tags with commas.</div>
            </div>

        </div>

        <div id="blockSettings" style="display: none;">
            <div class="settings-group" id="blockSettingsHintWrap">
                <strong>Block</strong>
                <div id="blockSettingsHint">Select a block to edit its settings</div>
            </div>
            <!-- Block inspector (ref: image 6) - shown when block selected -->
            <div id="blockInspector" style="display: none;">
                <div class="settings-group">
                    <strong id="blockInspectorTitle">H2 Heading 2</strong>
                    <p id="blockInspectorDesc" class="block-inspector-desc">Introduce new sections and organize content.</p>
                </div>
                <div class="settings-group" id="blockHeadingLevelGroup" style="display: none;">
                    <strong>Heading level</strong>
                    <div class="heading-level-btns" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;">
                        <button type="button" class="heading-level-btn" data-level="1">H1</button>
                        <button type="button" class="heading-level-btn" data-level="2">H2</button>
                        <button type="button" class="heading-level-btn" data-level="3">H3</button>
                        <button type="button" class="heading-level-btn" data-level="4">H4</button>
                        <button type="button" class="heading-level-btn" data-level="5">H5</button>
                        <button type="button" class="heading-level-btn" data-level="6">H6</button>
                    </div>
                </div>
                <div class="settings-group" id="blockColorGroup">
                    <strong>Color</strong>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:6px;">
                        <input type="color" id="blockColor" value="#1d2327" style="width:36px;height:36px;border:1px solid #dcdcde;border-radius:4px;cursor:pointer;">
                        <span>Text</span>
                    </div>
                </div>
                <div class="settings-group" id="blockFormatGroup">
                    <strong>Typography</strong>
                    <div class="settings-sub">
                        <label>FONT SIZE</label>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <select id="blockFontSize" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;flex:1;">
                                <option value="">Default</option>
                                <option value="12px">Small</option>
                                <option value="16px">Normal</option>
                                <option value="20px">Large</option>
                                <option value="24px">Larger</option>
                                <option value="custom">Custom</option>
                            </select>
                            <input
                                id="blockFontSizeCustom" type="range" min="8" max="72" step="1" value="16" style="display:none;width:120px;margin-left:8px;">
                            <span id="blockFontSizeCustomValue" style="display:none;min-width:42px;">16px</span>

                        </div>
                    </div>
                    <div class="settings-sub" style="margin-top:12px;">
                        <label>Font weight</label>
                        <select id="blockFontWeight" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                            <option value="normal">Normal</option>
                            <option value="bold">Bold</option>
                        </select>
                    </div>
                </div>
                <div class="settings-group" id="blockAlignGroup">
                    <strong>Alignment</strong>
                    <div style="display:flex;gap:8px;margin-top:6px;">
                        <button type="button" class="icon-btn" id="blockAlignLeft" title="Align left">≡</button>
                        <button type="button" class="icon-btn" id="blockAlignCenter" title="Center">≡</button>
                        <button type="button" class="icon-btn" id="blockAlignRight" title="Align right">≡</button>
                    </div>
                </div>
                <!-- Button settings (ref: image 3) -->
                <div class="settings-group" id="blockButtonSettingsGroup" style="display:none;">
                    <strong>Settings</strong>
                    <div class="settings-sub">
                        <label>WIDTH</label>
                        <div style="display:flex;gap:4px;margin-top:8px;">
                            <button type="button" class="width-btn" data-width="25%">25%</button>
                            <button type="button" class="width-btn" data-width="50%">50%</button>
                            <button type="button" class="width-btn" data-width="75%">75%</button>
                            <button type="button" class="width-btn" data-width="100%">100%</button>
                        </div>
                    </div>
                    <div class="settings-sub" style="margin-top:16px;">
                        <label>Attributes</label>
                        <input type="text" id="buttonUrl" placeholder="URL" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                        <input type="text" id="buttonText" placeholder="Text" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                        <select id="buttonLinkTarget" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                            <option value="_self">Same window</option>
                            <option value="_blank">New window</option>
                        </select>
                        <input type="text" id="buttonRel" placeholder="rel" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                        <button type="button" style="width:100%;padding:6px;margin-top:8px;border:1px solid #dcdcde;background:#fff;border-radius:4px;cursor:pointer;">Reset all</button>
                    </div>
                </div>
                <!-- Columns settings -->
                <div class="settings-group" id="blockColumnsSettingsGroup" style="display:none;">
                    <strong>Columns</strong>
                    <div class="settings-sub">
                        <label>Layout</label>
                        <div class="column-layout-mini" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;">
                            <button type="button" class="layout-mini-btn" data-cols="1" data-ratio="100">100</button>
                            <button type="button" class="layout-mini-btn" data-cols="2" data-ratio="50-50">50/50</button>
                            <button type="button" class="layout-mini-btn" data-cols="2" data-ratio="33-66">33/66</button>
                            <button type="button" class="layout-mini-btn" data-cols="2" data-ratio="66-33">66/33</button>
                            <button type="button" class="layout-mini-btn" data-cols="3" data-ratio="33-33-33">33/33/33</button>
                            <button type="button" class="layout-mini-btn" data-cols="3" data-ratio="25-50-25">25/50/25</button>
                        </div>
                    </div>
                </div>
                <div class="settings-group collapsible" id="blockDimensionsGroup">
                    <div class="block-settings-header">
                        <strong class="collapsible-toggle">Dimensions</strong>
                        <button type="button" class="block-settings-kebab" title="Options">⋮</button>
                    </div>
                    <div class="collapsible-content" style="display:none;margin-top:8px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                            <div>
                                <label style="font-size:11px;color:#50575e;">Width</label>
                                <input type="number" id="blockWidth" placeholder="auto" style="width:100%;padding:6px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                            </div>
                            <div>
                                <label style="font-size:11px;color:#50575e;">Height</label>
                                <input type="text" id="blockHeight" placeholder="auto" style="width:100%;padding:6px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                            </div>
                        </div>
                        <div class="settings-sub" style="margin-top:12px;">
                            <label>PADDING</label>
                            <div class="block-settings-slider-row">
                                <input type="range" id="blockPaddingSlider" min="0" max="80" value="0" title="Padding">
                                <input type="text" id="blockPadding" class="block-settings-px" placeholder="0" value="0">
                                <span class="block-settings-link-icon" title="Link">⇔</span>
                            </div>
                        </div>
                        <div class="settings-sub" style="margin-top:12px;">
                            <label>MARGIN</label>
                            <div class="block-settings-slider-row">
                                <input type="range" id="blockMarginSlider" min="0" max="80" value="0" title="Margin">
                                <input type="text" id="blockMargin" class="block-settings-px" placeholder="0" value="0">
                                <span class="block-settings-link-icon" title="Link">⇔</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="settings-group collapsible" id="blockBorderGroup">
                    <div class="block-settings-header">
                        <strong class="collapsible-toggle">Border</strong>
                        <button type="button" class="block-settings-kebab" title="Options">⋮</button>
                    </div>
                    <div class="collapsible-content" style="display:none;margin-top:8px;">
                        <div class="settings-sub">
                            <label>BORDER</label>
                            <div class="block-settings-slider-row">
                                <input type="range" id="blockBorderWidthSlider" min="0" max="20" value="0" title="Border width">
                                <input type="text" id="blockBorderWidth" class="block-settings-px" placeholder="0" value="0">
                                <span class="block-settings-link-icon" title="Link">⇔</span>
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:8px;">
                            <div>
                                <label style="font-size:11px;color:#50575e;">Style</label>
                                <select id="blockBorderStyle" style="width:100%;padding:6px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;">
                                    <option value="solid">Solid</option>
                                    <option value="dashed">Dashed</option>
                                    <option value="dotted">Dotted</option>
                                    <option value="none">None</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:11px;color:#50575e;">Color</label>
                                <input type="color" id="blockBorderColor" value="#dcdcde" style="width:100%;height:36px;border:1px solid #dcdcde;border-radius:4px;margin-top:4px;cursor:pointer;">
                            </div>
                        </div>
                        <div class="settings-sub" style="margin-top:12px;">
                            <label>RADIUS</label>
                            <div class="block-settings-slider-row">
                                <input type="range" id="blockBorderRadiusSlider" min="0" max="50" value="0" title="Radius">
                                <input type="text" id="blockBorderRadius" class="block-settings-px" placeholder="0" value="0">
                                <span class="block-settings-link-icon" title="Link">⇔</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="settings-group collapsible" id="blockAttributesGroup">
                    <div class="block-settings-header">
                        <strong class="collapsible-toggle">Attributes</strong>
                        <button type="button" class="block-settings-kebab" title="Options">⋮</button>
                    </div>
                    <div class="collapsible-content" style="display:none;margin-top:8px;">
                        <div class="block-settings-attr-row">
                            <strong>content</strong>
                            <span class="attr-not-connected">Not connected</span>
                        </div>
                        <p class="block-settings-attr-desc">Attributes connected to custom fields or other dynamic data.</p>
                        <input type="text" id="blockHtmlAnchor" placeholder="HTML Anchor" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:12px;">
                        <input type="text" id="blockCssClass" placeholder="Additional CSS class(es)" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;margin-top:8px;">
                    </div>
                </div>
                <div class="settings-group collapsible">
                    <strong class="collapsible-toggle">Advanced</strong>
                    <div class="collapsible-content" style="display:none;margin-top:8px;">
                        <textarea id="blockCustomCss" placeholder="Custom CSS" style="width:100%;padding:8px;border:1px solid #dcdcde;border-radius:4px;min-height:80px;font-family:monospace;font-size:12px;"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END wp-right -->

    <!-- Column layout picker modal -->
    <div class="column-layout-modal" id="columnLayoutModal">
        <div class="column-layout-content">
            <h3>Columns</h3>
            <p>Divide into columns. Select a layout:</p>
            <div class="column-layout-options" id="columnLayoutOptions">
                <button type="button" data-cols="1" data-ratio="100"><span class="cols-visual"><span style="width:24px"></span></span> 100</button>
                <button type="button" data-cols="2" data-ratio="50-50"><span class="cols-visual"><span></span><span></span></span> 50 / 50</button>
                <button type="button" data-cols="2" data-ratio="33-66"><span class="cols-visual"><span style="width:6px"></span><span style="width:18px"></span></span> 33 / 66</button>
                <button type="button" data-cols="2" data-ratio="66-33"><span class="cols-visual"><span style="width:18px"></span><span style="width:6px"></span></span> 66 / 33</button>
                <button type="button" data-cols="3" data-ratio="33-33-33"><span class="cols-visual"><span></span><span></span><span></span></span> 33 / 33 / 33</button>
                <button type="button" data-cols="3" data-ratio="25-50-25"><span class="cols-visual"><span style="width:6px"></span><span style="width:12px"></span><span style="width:6px"></span></span> 25 / 50 / 25</button>
            </div>
            <a class="skip-link" id="columnLayoutSkip">Skip</a>
        </div>
    </div>
</div>

<form
    id="saveForm"
    method="POST"
    action="{{ $isEdit ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}">
    @csrf
    <input type="hidden" name="title">
    <input type="hidden" name="content">
    <input type="hidden" name="status">
    <input type="hidden" name="reference_image">
    <input type="hidden" name="category_id">
    <input type="hidden" name="tags">
</form>


<script>
    /**
     * BLOG EDITOR - SCRIPT SECTIONS (use Ctrl+F to jump)
     * ----------------------------------------
     * 1. STATE MANAGEMENT - editor, title, history, undo/redo
     * 2. LIST VIEW - updateListViewModel(), getBlockLabel()
     * 3. BLOCK MANAGEMENT - wrapBlock(), reinitializeBlocks(), addParagraph(), addHeading(), addList(), addQuote(), addCode(), addPreformatted(), addTable(), addAccordion(), addButtons(), addColumns(), addGroup(), addRow(), addStack(), addGrid(), addSeparator(), addSpacer(), addImageBlock(), removeBlock()
     * 4. DRAG AND DROP - handleDragStart/Over/Drop/End (blocks + sidebar items)
     * 5. SLASH COMMAND - slashCommands, handleSlashCommand, showSlashMenu, updateSlashMenu, executeSlashCommand
     * 6. BLOCK FLOATING TOOLBAR - showBlockToolbar(), hideBlockToolbar(), syncBlockToolbarFromBlock(), tbBlockType, align, bold, italic, font size, color, block inspector (H1–H6, Color, Typography)
     * 7. BLOCK TOOLBAR MORE - duplicate, add before/after, delete
     * 8. FLOATING INSERTER - editor + button, popup grid, Browse all
     * 9. WP-LEFT TABS - Blocks / Patterns / Media
     * 10. PLUS TOOLBAR - toggle left sidebar (block inserter)
     * 11. LEFT SIDEBAR - addBlockByType(), block-item click/drag, column layout modal
     * 12. TOP BAR - List View toggle, undo/redo, command palette
     * 13. RIGHT SIDEBAR - featured image, status, slug, author, settings tabs, block inspector
     * 14. SAVE & PUBLISH - saveContent(), showPreview()
     * 15. INITIALIZE - saveState(), updatePostName(), updateLastEdited(), expose window.*
     */
    // ================= 1. STATE MANAGEMENT =================
    const editor = document.getElementById('editor');
    const title = document.getElementById('title');
    let history = [];
    let historyIndex = -1;
    let draggedBlock = null;
    let lastEditedTime = new Date();

    // Clipboard & style clipboard for toolbar “More” actions
    let clipboardBlockJson = null;
    let clipboardStyles = null;

    // Current insertion marker between blocks / columns
    let currentInsertMarker = null;
    let currentInsertColumn = null;
    // When set, floating inserter will insert at this context instead of at end (ref: image 3)
    let insertionContext = null;

    function slugify(text) {
        return (text || '')
            .toString()
            .trim()
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    // ================= UNDO/REDO SYSTEM =================
    function saveState() {
        const state = {
            html: editor.innerHTML,
            title: title.value
        };
        history = history.slice(0, historyIndex + 1);
        history.push(state);
        historyIndex++;
        updateUndoRedoButtons();
    }

    function undo() {
        if (historyIndex > 0) {
            historyIndex--;
            restoreState();
        }
    }

    function redo() {
        if (historyIndex < history.length - 1) {
            historyIndex++;
            restoreState();
        }
    }

    function restoreState() {
        const state = history[historyIndex];
        editor.innerHTML = state.html;
        title.value = state.title;
        updatePostName();
        reinitializeBlocks();
        updateListViewModel();
        updateUndoRedoButtons();
    }

    function updateUndoRedoButtons() {
        document.getElementById('undoBtn').disabled = historyIndex <= 0;
        document.getElementById('redoBtn').disabled = historyIndex >= history.length - 1;
    }

    // ================= LIST VIEW (ref: image 7) =================
    function getBlockLabel(block) {

        const type = block.dataset.type || 'paragraph';
        const content = block.querySelector('[contenteditable="true"]') || block.querySelector('h1, h2, h3, h4, h5, h6, blockquote, pre, ul, ol') || block.children[2];
        let name = type;
        if (type === 'heading' && content) {
            const tag = (content.tagName || '').toLowerCase();
            name = (tag.replace('h', '') || '2') + ' ' + (content.textContent || 'Heading').slice(0, 20);
            return 'H' + (tag.replace('h', '') || '2') + ' ' + (content.textContent || 'Heading').slice(0, 30);
        }
        const labels = {
            paragraph: '¶ Paragraph',
            list: '• List',
            quote: '" Quote',
            code: '<> Code',
            image: '🖼 Image',
            columns: '▌ Columns',
            accordion: '≡ Accordion',
            separator: '— Separator',
            spacer: '↗ Spacer'
        };
        // console.log(labels[type] || '¶ ' + type.charAt(0).toUpperCase() + type.slice(1));
        return labels[type] || '¶ ' + type.charAt(0).toUpperCase() + type.slice(1);
    }

    // Flat List View panel (top “List View” slideout)
    function updateListViewModel() {
        const list = document.getElementById('listViewList');
        if (!list) return;
        list.innerHTML = '';
        const blocks = editor.querySelectorAll('.block');
        blocks.forEach((block, index) => {
            const row = document.createElement('div');
            row.className = 'lv-item';
            row.dataset.index = index;
            row.innerHTML = '<span class="lv-item-label">' + getBlockLabel(block) + '</span><button type="button" class="lv-item-more">⋮</button>';
            row.querySelector('.lv-item-more').onclick = (e) => {
                e.stopPropagation(); /* block options */
            };
            row.onclick = (e) => {
                if (e.target.classList.contains('lv-item-more')) return;
                list.querySelectorAll('.lv-item').forEach(x => x.classList.remove('selected'));
                row.classList.add('selected');
                showBlockToolbar(block);
                block.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            };
            list.appendChild(row);
        });
    }

    // Helper to update BOTH list views whenever structure changes
    function refreshAllListViews() {
        updateListViewModel(); // existing slide-out List View
    }

    // ================= BLOCK MANAGEMENT =================
    function wrapBlock(el, type) {
        const block = document.createElement('div');
        block.className = 'block';
        block.dataset.type = type;
        block.draggable = true;

        const dragHandle = document.createElement('div');
        dragHandle.className = 'block-drag-handle';
        dragHandle.innerHTML = '⋮⋮';
        dragHandle.title = 'Drag to reorder';

        const controls = document.createElement('div');
        controls.className = 'block-controls';
        controls.innerHTML = `<button onclick="removeBlock(this)" title="Delete">+</button>`;

        block.appendChild(dragHandle);
        block.appendChild(controls);
        block.appendChild(el);
        editor.appendChild(block);

        // Bottom blue "+" marker: open quick-add popup (ref: image 3)
        // Display a centered "+" (plus) block inserter button like the WordPress block editor UI
        // Create a bottom "+" marker just like WordPress block editor's inserter UI (see screenshot)
        if (!block.querySelector('.block-insert-marker-bottom')) {
            const bottomMarker = document.createElement('div');
            bottomMarker.className = 'block-insert-marker block-insert-marker-bottom';
            // Flex row: divider - plus button - divider, visually centered, styled closely to WP editor
            bottomMarker.innerHTML = `<div style="flex:1;height:1px;background:#0066ff;"></div>
                <button type="button" class="block-insert-plus" style="">+</button>
                <div style="flex:1;height:1px;background:#0066ff;"></div>
            `;
            bottomMarker.style.display = 'flex';
            bottomMarker.style.alignItems = 'center';
            bottomMarker.style.justifyContent = 'center';
            bottomMarker.style.margin = '22px 0 12px 0';
            block.appendChild(bottomMarker);
            const bottomPlus = bottomMarker.querySelector('.block-insert-plus');
            bottomPlus.onclick = (e) => {
                e.stopPropagation();
                openFloatingInserter(bottomPlus, {
                    afterBlock: block
                });
            };
        }

        // Drag and drop handlers
        block.addEventListener('dragstart', handleDragStart);
        block.addEventListener('dragover', handleDragOver);
        block.addEventListener('drop', handleDrop);
        block.addEventListener('dragend', handleDragEnd);

        // Make content editable elements handle slash commands
        if (el.contentEditable === 'true') {
            el.addEventListener('input', handleSlashCommand);
            el.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    addParagraph();
                    setTimeout(() => {
                        const newBlock = editor.querySelector('.block:last-child [contenteditable]');
                        if (newBlock) newBlock.focus();
                    }, 0);
                }
            });
        }

        saveState();
        refreshAllListViews();
        return block;
    }

    // Attach blue "+" markers inside all columns: open quick-add popup (ref: image 3)
    /**
     * Attach a big initial "+" button (styled as shown in screenshot) if the column is empty,
     * then switch to regular small "+" divider once any block exists inside.
     */
    function attachColumnPlusButtons(root) {
        (root || document).querySelectorAll('.column').forEach(col => {
            // Remove any existing marker to avoid duplicates
            col.querySelectorAll('.block-insert-marker').forEach(marker => marker.remove());

            // If no blocks in this column, show large initial "+" button UI
            if (!col.querySelector('.block')) {
                const initialMarker = document.createElement('div');
                initialMarker.className = 'block-insert-marker initial-plus-marker';
                initialMarker.style.display = 'flex';
                initialMarker.style.justifyContent = 'center';
                initialMarker.style.alignItems = 'center';
                initialMarker.style.height = '48px';
                initialMarker.style.border = '2px solid #3366ee';
                initialMarker.style.borderRadius = '2px';
                initialMarker.style.margin = '16px auto';
                initialMarker.style.maxWidth = '96%';
                initialMarker.style.background = '#fff';

                // Style the plus button large and centered
                initialMarker.innerHTML = `<button type="button" class="block-insert-plus" 
                    style="
                        font-size: 26px;
                        width: 36px;
                        height: 36px;
                        border: none;
                        background: transparent;
                        color: #204be3;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        outline: none;
                    ">+</button>`;
                col.appendChild(initialMarker);

                const plusBtn = initialMarker.querySelector('.block-insert-plus');
                plusBtn.onclick = (e) => {
                    e.stopPropagation();
                    currentInsertColumn = col;
                    openFloatingInserter(plusBtn, {
                        insideColumn: col,
                        marker: initialMarker
                    });
                };

            } else {
                // Otherwise, show regular (thin line with +) insert marker
                const marker = document.createElement('div');
                marker.className = 'block-insert-marker';
                marker.style.display = 'flex';
                marker.style.alignItems = 'center';
                marker.innerHTML = `
                    <div style="flex:1;height:1px;background:#0066ff;"></div>
                    <button type="button" class="block-insert-plus" style="
                        font-size: 20px;
                        width: 28px;
                        height: 28px;
                        border: none;
                        background: #fff;
                        color: #204be3;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        outline: none;"></button>
                    <div style="flex:1;height:1px;background:#0066ff;"></div>
                `;
                marker.querySelector('.block-insert-plus').textContent = '+';
                marker.style.margin = '16px 0 12px 0';
                col.appendChild(marker);

                const plusBtn = marker.querySelector('.block-insert-plus');
                plusBtn.onclick = (e) => {
                    e.stopPropagation();
                    currentInsertColumn = col;
                    openFloatingInserter(plusBtn, {
                        insideColumn: col,
                        marker: marker
                    });
                };
            }
        });
    }

    function reinitializeBlocks() {
        document.querySelectorAll('.block').forEach(block => {
            block.draggable = true;
            block.addEventListener('dragstart', handleDragStart);
            block.addEventListener('dragover', handleDragOver);
            block.addEventListener('drop', handleDrop);
            block.addEventListener('dragend', handleDragEnd);

            const editable = block.querySelector('[contenteditable]');
            if (editable) {
                editable.addEventListener('input', handleSlashCommand);
            }

            // Reinitialize accordion toggles
            if (block.dataset.type === 'accordion') {
                block.querySelectorAll('.accordion-toggle').forEach(toggle => {
                    toggle.onclick = (e) => {
                        e.stopPropagation();
                        const body = toggle.closest('.block-accordion-item').querySelector('.block-accordion-body');
                        if (body) {
                            const isOpen = body.style.display !== 'none';
                            body.style.display = isOpen ? 'none' : 'block';
                            toggle.textContent = isOpen ? '+' : '−';
                        }
                    };
                });
            }
            // Ensure bottom "+" marker exists after restoring from HTML
            if (!block.querySelector('.block-insert-marker-bottom')) {
                const bottomMarker = document.createElement('div');
                bottomMarker.className = 'block-insert-marker block-insert-marker-bottom';
                bottomMarker.innerHTML = `<div style="flex:1;height:1px;background:#0066ff;"></div>
                <button type="button" class="block-insert-plus" style="">+</button>
                <div style="flex:1;height:1px;background:#0066ff;"></div>`;
                bottomMarker.style.display = 'flex';
                bottomMarker.style.alignItems = 'center';
                bottomMarker.style.justifyContent = 'center';
                bottomMarker.style.margin = '22px 0 12px 0';
                block.appendChild(bottomMarker);
                const bottomPlus = bottomMarker.querySelector('.block-insert-plus');
                bottomPlus.onclick = (e) => {
                    e.stopPropagation();
                    openFloatingInserter(bottomPlus, {
                        afterBlock: block
                    });
                };
            }
        });
    }

    function addParagraph() {
        const p = document.createElement('div');
        p.contentEditable = true;
        p.innerText = '';
        p.setAttribute('data-placeholder', 'Type / to choose a block');
        const block = wrapBlock(p, 'paragraph');
        p.focus();
        return block;
    }

    function addHeading(level) {
        // Only declare function, do not bind to window to avoid recursion stack overflow
        const tag = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'][level - 1] || 'h2';
        const h = document.createElement(tag);
        h.contentEditable = true;
        h.innerText = 'Heading';
        h.dataset.headingLevel = level;

        // Do not use window.addHeading inside here -- use function reference as-is for toolbar, etc.

        const block = wrapBlock(h, 'heading');
        setTimeout(() => {
            h.focus();
            try {
                document.execCommand('selectAll', false, null);
            } catch (e) {}
        }, 0);
        return block;
    }

    function addList() {
        const ul = document.createElement('ul');
        ul.className = 'block-list';
        ul.contentEditable = true;
        ul.innerHTML = '<li>List item 1</li><li>List item 2</li>';
        const block = wrapBlock(ul, 'list');
        return block;
    }

    function addQuote() {
        const block = document.createElement('blockquote');
        block.contentEditable = true;
        block.innerText = 'Quote text';
        const wrapped = wrapBlock(block, 'quote');
        block.focus();
        return wrapped;
    }

    function addCode() {
        const pre = document.createElement('pre');
        pre.className = 'code-block';
        pre.contentEditable = true;
        pre.innerText = '// Code here';
        const block = wrapBlock(pre, 'code');
        pre.focus();
        return block;
    }

    function addPreformatted() {
        const pre = document.createElement('pre');
        pre.contentEditable = true;
        pre.innerText = 'Preformatted text';
        wrapBlock(pre, 'preformatted');
        pre.focus();
    }

    function addTable() {

        // Container
        const wrapper = document.createElement('div');
        wrapper.className = 'wp-table-setup';

        wrapper.innerHTML = `
            <div style="padding:16px;border:1px solid #dcdcde;border-radius:6px;background:#fff;">
                <strong style="display:block;margin-bottom:10px;">Table</strong>
                <p style="margin-bottom:12px;color:#555;">Insert a table for sharing data.</p>

                <div style="display:flex;gap:12px;margin-bottom:12px;">
                    <div>
                        <label style="font-size:12px;">COLUMN COUNT</label> 
                        <input type="number" min="1" value="2" class="table-cols"
                            style="width:80px;padding:6px;border:1px solid #ccc;border-radius:4px;">
                    </div>
                    <div>
                        <label style="font-size:12px;">ROW COUNT</label>
                        <input type="number" min="1" value="2" class="table-rows"
                            style="width:80px;padding:6px;border:1px solid #ccc;border-radius:4px;">
                    </div>
                </div>

                <button type="button" class="create-table-btn"
                    style="background:#3858e9;color:#fff;border:none;padding:8px 14px;border-radius:4px;cursor:pointer;">
                    Create Table
                </button>
            </div>
        `;

        const block = wrapBlock(wrapper, 'table');

        const createBtn = wrapper.querySelector('.create-table-btn');

        createBtn.onclick = () => {
            const cols = parseInt(wrapper.querySelector('.table-cols').value, 10);
            const rows = parseInt(wrapper.querySelector('.table-rows').value, 10);

            if (!cols || !rows || cols < 1 || rows < 1) {
                alert('Rows and columns must be greater than 0');
                return;
            }

            // Build table
            const table = document.createElement('table');
            table.style.width = '100%';
            table.style.borderCollapse = 'collapse';
            table.setAttribute('border', '1');

            for (let r = 0; r < rows; r++) {
                const tr = document.createElement('tr');
                for (let c = 0; c < cols; c++) {
                    const td = document.createElement('td');
                    td.contentEditable = true;
                    td.innerText = 'Cell';
                    td.style.padding = '8px';
                    td.style.border = '1px solid #ccc';
                    tr.appendChild(td);
                }
                table.appendChild(tr);
            }

            // Replace setup UI with actual table
            wrapper.innerHTML = '';
            wrapper.appendChild(table);

            saveState();
            refreshAllListViews();
        };
    }

    function addAccordion() {
        const wrap = document.createElement('div');
        wrap.className = 'block-accordion';
        wrap.dataset.type = 'accordion';
        const item = document.createElement('div');
        item.className = 'block-accordion-item';
        const title = document.createElement('div');
        title.className = 'block-accordion-title';
        const titleText = document.createElement('span');
        titleText.contentEditable = true;
        titleText.innerText = 'Accordion title';
        const toggle = document.createElement('span');
        toggle.className = 'accordion-toggle';
        toggle.textContent = '+';
        toggle.style.cursor = 'pointer';
        toggle.style.userSelect = 'none';
        title.appendChild(titleText);
        title.appendChild(toggle);
        const body = document.createElement('div');
        body.className = 'block-accordion-body';
        body.style.display = 'none';
        const content = document.createElement('div');
        content.contentEditable = true;
        content.setAttribute('data-placeholder', 'Content');
        content.innerText = 'Content here';
        body.appendChild(content);
        item.appendChild(title);
        item.appendChild(body);
        wrap.appendChild(item);
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = body.style.display !== 'none';
            body.style.display = isOpen ? 'none' : 'block';
            toggle.textContent = isOpen ? '+' : '−';
        });
        wrapBlock(wrap, 'accordion');
    }

    function addButtons() {
        const wrap = document.createElement('div');
        wrap.className = 'block-buttons-inner';
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn-inline primary';
        btn.contentEditable = true;
        btn.innerText = 'Button';
        btn.dataset.url = '';
        btn.dataset.linkTarget = '_self';
        wrap.appendChild(btn);
        wrapBlock(wrap, 'buttons');
    }

    function addColumns(cols, ratio) {
        const wrap = document.createElement('div');
        wrap.className = 'columns';
        wrap.dataset.cols = cols;
        if (ratio) wrap.dataset.ratio = ratio;

        for (let i = 0; i < cols; i++) {
            const col = document.createElement('div');
            col.className = 'column';
            col.dataset.colIndex = i;
            wrap.appendChild(col);
        }

        const block = wrapBlock(wrap, 'columns');
        attachColumnPlusButtons(block);
    }

    function addGroup() {
        const wrap = document.createElement('div');
        wrap.className = 'block-group';
        wrap.contentEditable = true;
        wrap.innerText = 'Group content';
        wrap.setAttribute('data-placeholder', 'Group content');
        wrapBlock(wrap, 'group');
        wrap.focus();
    }

    function addRow() {
        const wrap = document.createElement('div');
        wrap.className = 'block-row';
        wrap.style.display = 'flex';
        wrap.style.gap = '16px';
        const inner = document.createElement('div');
        inner.contentEditable = true;
        inner.innerText = 'Row content';
        wrap.appendChild(inner);
        wrapBlock(wrap, 'row');
    }

    function addStack() {
        const wrap = document.createElement('div');
        wrap.className = 'block-stack';
        wrap.innerHTML = '<div contenteditable="true" data-placeholder="Item 1">Item 1</div><div contenteditable="true" data-placeholder="Item 2">Item 2</div>';
        wrapBlock(wrap, 'stack');
    }

    function addGrid() {
        const wrap = document.createElement('div');
        wrap.className = 'columns';
        wrap.dataset.cols = 3;
        wrap.dataset.ratio = '33-33-33';
        for (let i = 0; i < 3; i++) {
            const col = document.createElement('div');
            col.className = 'column';
            col.contentEditable = true;
            col.innerText = 'Grid cell';
            wrap.appendChild(col);
        }
        wrapBlock(wrap, 'grid');
    }

    function addSeparator() {
        const el = document.createElement('div');
        el.className = 'block-separator';
        wrapBlock(el, 'separator');
    }

    function addSpacer() {
        const el = document.createElement('div');
        el.className = 'block-spacer';
        wrapBlock(el, 'spacer');
    }

    function addImageBlock() {
        const wrap = document.createElement('div');
        wrap.className = 'block-image-inner';

        function renderImageActions() {
            // Remounts the UI for upload/select/url buttons
            wrap.innerHTML = `
                <div class="block-image-instruction">Drag and drop an image, upload, or choose from your library.</div>
                <div class="block-image-actions">
                    <button type="button" class="btn-upload block-img-upload">Upload</button>
                    <button type="button" class="btn-secondary block-img-select">Select Image</button>
                    <button type="button" class="btn-secondary block-img-url">Insert from URL</button>
                </div>
                <input type="file" class="block-img-file" accept="image/*" style="display:none">
            `;
            bindActions();
        }

        function renderWithImage(imageSrc) {
            wrap.classList.add('has-image');
            wrap.innerHTML = `
                <div style="position:relative; text-align:center;">
                    <img src="${imageSrc}" alt="" style="max-width:100%;margin:auto;display:block;">
                    <button type="button" class="btn-secondary block-img-replace" style="position:absolute;top:8px;right:8px;z-index:2;" title="Replace">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M20 17.17V13a1 1 0 1 1 2 0v7a1 1 0 0 1-1 1h-7a1 1 0 1 1 0-2h4.17L4.93 4.93a1 1 0 0 1 1.41-1.41l15.13 15.13a1 1 0 0 1-1.41 1.41L20 17.17z" fill="#555"/><path d="M2 6.83V11a1 1 0 1 0 2 0V6.83L19.07 19.07a1 1 0 0 0 1.41-1.41L4.93 4.93A1 1 0 1 0 3.51 6.34L2 6.83z" fill="#555"/></svg>
                    </button>
                </div>
            `;
            const replaceBtn = wrap.querySelector('.block-img-replace');
            if (replaceBtn) {
                replaceBtn.onclick = (e) => {
                    e.stopPropagation();
                    renderImageActions();
                };
            }
        }

        function bindActions() {
            wrap.querySelector('.block-img-upload').onclick = () => wrap.querySelector('.block-img-file').click();
            wrap.querySelector('.block-img-file').onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        renderWithImage(ev.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            };
            // If you have a file manager/modal for Select Image, hook it here
            // For now, we'll just prompt as a stub like Insert from URL
            wrap.querySelector('.block-img-select').onclick = () => {
                const url = prompt('Enter image URL (from "Select Image"):');
                if (url) {
                    renderWithImage(url);
                }
            };
            wrap.querySelector('.block-img-url').onclick = () => {
                const url = prompt('Enter image URL:');
                if (url) {
                    renderWithImage(url);
                }
            };
        }

        renderImageActions();
        const block = wrapBlock(wrap, 'image');
    }

    function removeBlock(btn) {
        btn.closest('.block').remove();
        saveState();
        refreshAllListViews();
    }

    // Helpers for clipboard JSON (toolbar “More”)
    function blockToJson(block) {
        return {
            type: block.dataset.type || 'paragraph',
            html: block.innerHTML,
            hidden: block.classList.contains('is-hidden'),
            locked: block.dataset.locked === '1',
            label: block.dataset.label || getBlockLabel(block),
        };
    }

    function jsonToDomBlock(json) {
        const div = document.createElement('div');
        div.className = 'block';
        div.dataset.type = json.type || 'paragraph';
        div.innerHTML = json.html || '';
        if (json.hidden) div.classList.add('is-hidden');
        if (json.locked) div.dataset.locked = '1';
        if (json.label) div.dataset.label = json.label;
        return div;
    }

    // ================= DRAG AND DROP =================
    function handleDragStart(e) {
        draggedBlock = this;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';

        if (this !== draggedBlock) {
            this.classList.add('drag-over');
        }
        return false;
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }

        if (draggedBlock !== this) {
            const allBlocks = Array.from(editor.querySelectorAll('.block'));
            const draggedIndex = allBlocks.indexOf(draggedBlock);
            const targetIndex = allBlocks.indexOf(this);

            if (draggedIndex < targetIndex) {
                editor.insertBefore(draggedBlock, this.nextSibling);
            } else {
                editor.insertBefore(draggedBlock, this);
            }
        }

        document.querySelectorAll('.block').forEach(block => {
            block.classList.remove('drag-over');
        });

        saveState();
        return false;
    }

    function handleDragEnd(e) {
        document.querySelectorAll('.block').forEach(block => {
            block.classList.remove('dragging', 'drag-over');
        });
        draggedBlock = null;
    }

    // ================= SLASH COMMAND =================
    const slashCommands = [{
            name: 'Paragraph',
            desc: 'Start writing with plain text',
            icon: '¶',
            action: () => addParagraph()
        },
        {
            name: 'Heading',
            desc: 'Big section heading',
            icon: 'H',
            action: () => addHeading(2)
        },
        {
            name: 'List',
            desc: 'Create a bulleted or numbered list',
            icon: '•',
            action: () => addList()
        },
        {
            name: 'Quote',
            desc: 'Add a block quote',
            icon: '"',
            action: () => addQuote()
        },
        {
            name: 'Code',
            desc: 'Display code snippet',
            icon: '<>',
            action: () => addCode()
        },
        {
            name: 'Image',
            desc: 'Insert an image',
            icon: '🖼',
            action: () => addImageBlock()
        },
        {
            name: '2 Columns',
            desc: 'Add a two column layout',
            icon: '▌',
            action: () => addColumns(2)
        },
        {
            name: '3 Columns',
            desc: 'Add a three column layout',
            icon: '▌',
            action: () => addColumns(3)
        },
        {
            name: 'Accordion',
            desc: 'Collapsible accordion',
            icon: '≡',
            action: () => addAccordion()
        },
        {
            name: 'Separator',
            desc: 'Horizontal line',
            icon: '—',
            action: () => addSeparator()
        },
        {
            name: 'Spacer',
            desc: 'Add vertical space',
            icon: '↗',
            action: () => addSpacer()
        },
    ];

    let slashMenuVisible = false;
    let slashMenuSelectedIndex = 0;
    let currentSlashElement = null;

    function handleSlashCommand(e) {
        const text = e.target.innerText || e.target.textContent;
        const cursorPos = window.getSelection().getRangeAt(0).startOffset;
        const textBeforeCursor = text.substring(0, cursorPos);

        if (textBeforeCursor.endsWith('/')) {
            showSlashMenu(e.target);
        } else if (slashMenuVisible && currentSlashElement === e.target) {
            updateSlashMenu(textBeforeCursor);
        } else {
            hideSlashMenu();
        }
    }

    function showSlashMenu(element) {
        currentSlashElement = element;
        slashMenuVisible = true;
        slashMenuSelectedIndex = 0;

        const menu = document.getElementById('slashMenu');
        menu.innerHTML = '';
        slashCommands.forEach((cmd, index) => {
            const item = document.createElement('div');
            item.className = 'slash-menu-item' + (index === 0 ? ' selected' : '');
            item.innerHTML = `
                <div class="slash-menu-item-icon">${cmd.icon}</div>
                <div class="slash-menu-item-text">
                    <strong>${cmd.name}</strong>
                    <span>${cmd.desc}</span>
                </div>
            `;
            item.onclick = () => executeSlashCommand(cmd);
            menu.appendChild(item);
        });

        const rect = element.getBoundingClientRect();
        const editorRect = editor.getBoundingClientRect();
        menu.style.top = (rect.bottom - editorRect.top + 10) + 'px';
        menu.style.left = (rect.left - editorRect.left) + 'px';
        menu.classList.add('show');
    }

    function updateSlashMenu(query) {
        const searchTerm = query.substring(query.lastIndexOf('/') + 1).toLowerCase();
        const filtered = slashCommands.filter(cmd =>
            cmd.name.toLowerCase().includes(searchTerm) ||
            cmd.desc.toLowerCase().includes(searchTerm)
        );

        const menu = document.getElementById('slashMenu');
        menu.innerHTML = '';

        if (filtered.length === 0) {
            menu.classList.remove('show');
            return;
        }

        filtered.forEach((cmd, index) => {
            const item = document.createElement('div');
            item.className = 'slash-menu-item' + (index === 0 ? ' selected' : '');
            item.innerHTML = `
                <div class="slash-menu-item-icon">${cmd.icon}</div>
                <div class="slash-menu-item-text">
                    <strong>${cmd.name}</strong>
                    <span>${cmd.desc}</span>
                </div>
            `;
            item.onclick = () => executeSlashCommand(cmd);
            menu.appendChild(item);
        });

        slashMenuSelectedIndex = 0;
    }

    function executeSlashCommand(cmd) {
        if (currentSlashElement) {
            const text = currentSlashElement.innerText || currentSlashElement.textContent;
            const cursorPos = window.getSelection().getRangeAt(0).startOffset;
            const textBeforeSlash = text.substring(0, text.lastIndexOf('/'));
            currentSlashElement.innerText = textBeforeSlash;
        }
        hideSlashMenu();
        cmd.action();
    }

    function hideSlashMenu() {
        slashMenuVisible = false;
        currentSlashElement = null;
        document.getElementById('slashMenu').classList.remove('show');
    }

    // Handle keyboard navigation in slash menu
    // Keyboard shortcuts for toolbar actions
    document.addEventListener('keydown', (e) => {
        if (selectedBlock) {
            const ctrl = e.ctrlKey || e.metaKey;
            if (ctrl && e.key.toLowerCase() === 'c') { // Copy
                e.preventDefault();
                clipboardBlockJson = blockToJson(selectedBlock);
            } else if (ctrl && e.key.toLowerCase() === 'x') { // Cut
                e.preventDefault();
                clipboardBlockJson = blockToJson(selectedBlock);
                selectedBlock.remove();
                hideBlockToolbar();
                saveState();
                refreshAllListViews();
            } else if (ctrl && e.shiftKey && e.key.toLowerCase() === 'd') { // Duplicate
                e.preventDefault();
                const clone = selectedBlock.cloneNode(true);
                selectedBlock.parentNode.insertBefore(clone, selectedBlock.nextSibling);
                reinitializeBlocks();
                saveState();
                refreshAllListViews();
            } else if (ctrl && e.altKey && (e.key === 't' || e.key === 'T')) { // Add before
                e.preventDefault();
                const b = addParagraph();
                if (b && b.parentNode === editor) {
                    editor.removeChild(b);
                    editor.insertBefore(b, selectedBlock);
                }
                saveState();
                refreshAllListViews();
            } else if (ctrl && e.altKey && (e.key === 'y' || e.key === 'Y')) { // Add after
                e.preventDefault();
                const b = addParagraph();
                if (b && b.parentNode === editor) {
                    editor.removeChild(b);
                    editor.insertBefore(b, selectedBlock.nextSibling);
                }
                saveState();
                refreshAllListViews();
            } else if (e.shiftKey && e.altKey && e.key.toLowerCase() === 'z') { // Delete
                e.preventDefault();
                selectedBlock.remove();
                hideBlockToolbar();
                saveState();
                refreshAllListViews();
            }
        }

        if (slashMenuVisible) {
            const menu = document.getElementById('slashMenu');
            const items = menu.querySelectorAll('.slash-menu-item');

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                slashMenuSelectedIndex = Math.min(slashMenuSelectedIndex + 1, items.length - 1);
                updateSlashMenuSelection(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                slashMenuSelectedIndex = Math.max(slashMenuSelectedIndex - 1, 0);
                updateSlashMenuSelection(items);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (items[slashMenuSelectedIndex]) {
                    items[slashMenuSelectedIndex].click();
                }
            } else if (e.key === 'Escape') {
                hideSlashMenu();
            }
        }
    });

    function updateSlashMenuSelection(items) {
        items.forEach((item, index) => {
            item.classList.toggle('selected', index === slashMenuSelectedIndex);
        });
    }

    // ================= BLOCK FLOATING TOOLBAR =================
    let selectedBlock = null;
    let selectedBlockContent = null;

    function getBlockContentEl(block) {
        if (!block) return null;
        const type = block.dataset.type;
        if (type === 'image') {
            // Allow alignment & dimension controls on image itself
            return block.querySelector('.block-image-inner img') || block.querySelector('img');
        }
        if (type === 'columns' || type === 'accordion' || type === 'buttons' || type === 'separator' || type === 'spacer') return null;
        return block.querySelector('[contenteditable="true"]') || block.querySelector('h1, h2, h3, h4, h5, h6, div, blockquote, pre, ul, ol') || block.children[2];
    }

    function showBlockToolbar(block) {
        selectedBlock = block;
        selectedBlockContent = getBlockContentEl(block);
        const toolbar = document.getElementById('blockToolbar');
        const wrapper = document.getElementById('editorWrapper');
        const rect = block.getBoundingClientRect();
        const wrapperRect = wrapper.getBoundingClientRect();
        toolbar.style.top = (rect.top - wrapperRect.top - 48) + 'px';
        toolbar.style.left = (rect.left - wrapperRect.left) + 'px';
        toolbar.classList.add('show');
        document.querySelectorAll('.settings-tabs button[data-tab="block"]').forEach(btn => btn.click());
        document.getElementById('blockSettings').style.display = 'block';
        const hintWrap = document.getElementById('blockSettingsHintWrap');
        const inspector = document.getElementById('blockInspector');
        const type = block.dataset.type || '';
        const content = selectedBlockContent;

        // Hide all toolbar sections first
        document.querySelectorAll('.tb-section').forEach(s => s.style.display = 'none');

        // Show relevant sections based on block type
        if (type === 'columns' || type === 'grid') {
            document.getElementById('tbColumnsSection').style.display = 'flex';
        } else if (type === 'buttons') {
            document.getElementById('tbButtonsSection').style.display = 'flex';
        } else if (selectedBlockContent) {
            // Text blocks
            document.getElementById('tbTextSection').style.display = 'flex';
            document.getElementById('tbFormatSection').style.display = 'flex';
        }

        if (hintWrap) hintWrap.style.display = selectedBlockContent || type === 'columns' || type === 'buttons' ? 'none' : 'block';
        if (inspector) inspector.style.display = selectedBlockContent || type === 'columns' || type === 'buttons' ? 'block' : 'none';
        const hasFormat = !!selectedBlockContent;

        if (inspector) {
            if (type === 'heading' && content) {
                document.getElementById('blockInspectorTitle').textContent = 'H' + (content.tagName || '').replace('H', '') + ' Heading ' + (content.tagName || '').replace('H', '');
                document.getElementById('blockInspectorDesc').textContent = 'Introduce new sections and organize content to help visitors (and search engines) understand the structure of your content.';
                document.getElementById('blockHeadingLevelGroup').style.display = 'block';
                document.getElementById('blockButtonSettingsGroup').style.display = 'none';
                document.getElementById('blockColumnsSettingsGroup').style.display = 'none';
            } else if (type === 'buttons') {
                document.getElementById('blockInspectorTitle').textContent = 'Button';
                document.getElementById('blockInspectorDesc').textContent = 'Prompt visitors to take action with a button-style link.';
                document.getElementById('blockHeadingLevelGroup').style.display = 'none';
                document.getElementById('blockButtonSettingsGroup').style.display = 'block';
                document.getElementById('blockColumnsSettingsGroup').style.display = 'none';
            } else if (type === 'columns' || type === 'grid') {
                document.getElementById('blockInspectorTitle').textContent = 'Columns';
                document.getElementById('blockInspectorDesc').textContent = 'Create multi-column layouts.';
                document.getElementById('blockHeadingLevelGroup').style.display = 'none';
                document.getElementById('blockColumnsSettingsGroup').style.display = 'block';
                document.getElementById('blockButtonSettingsGroup').style.display = 'none';
            } else {
                document.getElementById('blockInspectorTitle').textContent = type.charAt(0).toUpperCase() + type.slice(1);
                document.getElementById('blockInspectorDesc').textContent = 'Block settings.';
                document.getElementById('blockHeadingLevelGroup').style.display = 'none';
                document.getElementById('blockButtonSettingsGroup').style.display = 'none';
                document.getElementById('blockColumnsSettingsGroup').style.display = 'none';
            }
        }
        document.getElementById('blockFormatGroup').style.display = hasFormat && type !== 'buttons' && type !== 'columns' ? 'block' : 'none';
        document.getElementById('blockAlignGroup').style.display = hasFormat && type !== 'buttons' && type !== 'columns' ? 'block' : 'none';
        document.getElementById('blockColorGroup').style.display = hasFormat && type !== 'buttons' && type !== 'columns' ? 'block' : 'none';
        syncBlockToolbarFromBlock();
        if (type === 'heading' && content) {
            document.querySelectorAll('.heading-level-btn').forEach(btn => {
                btn.classList.toggle('active', (content.tagName || '').toLowerCase() === 'h' + btn.dataset.level);
            });
        }
        if (type === 'columns' || type === 'grid') {
            syncColumnToolbar(block);
        }
        if (type === 'buttons') {
            syncButtonToolbar(block);
        }
    }

    function hideBlockToolbar() {
        selectedBlock = null;
        selectedBlockContent = null;
        document.getElementById('blockToolbar').classList.remove('show');
        document.getElementById('blockToolbarMore').classList.remove('show');
        const hintWrap = document.getElementById('blockSettingsHintWrap');
        const inspector = document.getElementById('blockInspector');
        if (hintWrap) hintWrap.style.display = 'block';
        if (inspector) inspector.style.display = 'none';
        document.getElementById('blockFormatGroup').style.display = 'none';
        document.getElementById('blockAlignGroup').style.display = 'none';
        document.getElementById('blockColorGroup').style.display = 'none';
    }

    function syncBlockToolbarFromBlock() {
        const el = selectedBlockContent;
        if (!el) return;
        const tb = document.getElementById('tbBlockType');
        const transformLabel = document.getElementById('tbTransformLabel');
        const transformIcon = document.getElementById('tbTransformIcon');
        const labels = {
            paragraph: 'P',
            h1: 'H1',
            h2: 'H2',
            h3: 'H3',
            h4: 'H4',
            h5: 'H5',
            h6: 'H6',
            quote: 'Q',
            code: 'C',
            list: 'Li',
        };
        const icons = {
            paragraph: '¶',
            h1: 'H1',
            h2: 'H2',
            h3: 'H3',
            h4: 'H4',
            h5: 'H5',
            h6: 'H6',
            quote: '"',
            code: '</>',
            list: '≡',
        };
        if (tb) {
            const tag = (el.tagName || '').toLowerCase();
            if (tag === 'h1') tb.value = 'h1';
            else if (tag === 'h2') tb.value = 'h2';
            else if (tag === 'h3') tb.value = 'h3';
            else if (tag === 'h4') tb.value = 'h4';
            else if (tag === 'h5') tb.value = 'h5';
            else if (tag === 'h6') tb.value = 'h6';
            else if (tag === 'blockquote') tb.value = 'quote';
            else if (tag === 'pre') tb.value = el.classList.contains('code-block') ? 'code' : 'preformatted';
            else if (tag === 'ul' || tag === 'ol') tb.value = 'list';
            else tb.value = 'paragraph';
        }
        if (transformLabel) transformLabel.textContent = labels[tb?.value] || 'Paragraph';
        if (transformIcon) transformIcon.textContent = icons[tb?.value] || '¶';
        document.querySelectorAll('.tb-transform-option').forEach(opt => {
            opt.classList.toggle('active', opt.dataset.transform === tb?.value);
        });
        const fs = document.getElementById('tbFontSize');
        if (fs) fs.value = el.style.fontSize || '';
        const tc = document.getElementById('tbColor');
        if (tc) tc.value = rgbToHex(el.style.color) || '#1d2327';
        const bfs = document.getElementById('blockFontSize');
        if (bfs) bfs.value = el.style.fontSize || '';
        const bfw = document.getElementById('blockFontWeight');
        if (bfw) bfw.value = el.style.fontWeight === 'bold' ? 'bold' : 'normal';
        const bc = document.getElementById('blockColor');
        if (bc) bc.value = tc ? tc.value : '#1d2327';
        const bb = document.getElementById('blockBgColor');
        if (bb) bb.value = rgbToHex(el.style.backgroundColor) || '#ffffff';
        const padInput = document.getElementById('blockPadding');
        const padSlider = document.getElementById('blockPaddingSlider');
        const marginInput = document.getElementById('blockMargin');
        const marginSlider = document.getElementById('blockMarginSlider');
        if (padInput) padInput.value = parsePx(el.style.padding) || 0;
        if (padSlider) padSlider.value = parsePx(el.style.padding) || 0;
        if (marginInput) marginInput.value = parsePx(el.style.margin) || 0;
        if (marginSlider) marginSlider.value = parsePx(el.style.margin) || 0;
        const borderWInput = document.getElementById('blockBorderWidth');
        const borderWSlider = document.getElementById('blockBorderWidthSlider');
        if (borderWInput) borderWInput.value = parsePx(el.style.borderWidth) || 0;
        if (borderWSlider) borderWSlider.value = parsePx(el.style.borderWidth) || 0;
        const radiusInput = document.getElementById('blockBorderRadius');
        const radiusSlider = document.getElementById('blockBorderRadiusSlider');
        if (radiusInput) radiusInput.value = parsePx(el.style.borderRadius) || 0;
        if (radiusSlider) radiusSlider.value = parsePx(el.style.borderRadius) || 0;
        const borderStyleInput = document.getElementById('blockBorderStyle');
        if (borderStyleInput) borderStyleInput.value = el.style.borderStyle || 'solid';
        const borderColorInput = document.getElementById('blockBorderColor');
        if (borderColorInput) borderColorInput.value = rgbToHex(el.style.borderColor) || '#dcdcde'
    }

    function syncColumnToolbar(block) {
        const cols = block.dataset.cols || '2';
        const ratio = block.dataset.ratio || '';
        document.querySelectorAll('.layout-mini-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.cols === cols && btn.dataset.ratio === ratio);
        });
    }

    function syncButtonToolbar(block) {
        const btn = block.querySelector('.btn-inline');
        if (!btn) return;
        const width = btn.style.width || '100%';
        document.querySelectorAll('.width-btn').forEach(b => {
            b.classList.toggle('active', b.dataset.width === width);
        });
        const url = document.getElementById('buttonUrl');
        const text = document.getElementById('buttonText');
        const target = document.getElementById('buttonLinkTarget');
        const rel = document.getElementById('buttonRel');
        if (url) url.value = btn.dataset.url || '';
        if (text) text.value = btn.innerText || '';
        if (target) target.value = btn.dataset.linkTarget || '_self';
        if (rel) rel.value = btn.dataset.rel || '';
    }

    function rgbToHex(rgb) {
        if (!rgb || rgb.startsWith('#')) return rgb;
        const m = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        if (!m) return null;
        return '#' + [1, 2, 3].map(i => ('0' + parseInt(m[i], 10).toString(16)).slice(-2)).join('');
    }

    function parsePx(value) {
        if (!value) return 0;
        const num = parseFloat(value.toString().replace('px', ''));
        return Number.isNaN(num) ? 0 : num;
    }

    function applyFontSize(value) {
        if (!selectedBlockContent) return;
        const selection = window.getSelection ? window.getSelection() : null;
        if (selection && selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            const inBlock = selectedBlockContent.contains(range.commonAncestorContainer);
            if (inBlock && !selection.isCollapsed && value) {
                const span = document.createElement('span');
                span.style.fontSize = value;
                const contents = range.extractContents();
                span.appendChild(contents);
                range.insertNode(span);
                selection.removeAllRanges();
                const newRange = document.createRange();
                newRange.selectNodeContents(span);
                selection.addRange(newRange);
                return;
            }
        }
        selectedBlockContent.style.fontSize = value || '';
    }

    function applyBlockTransform(val) {
        if (!selectedBlockContent) return;
        if (val === 'details') return; /* structural, skip */
        const tag = val === 'paragraph' ? 'div' : (val === 'quote' ? 'blockquote' : (val === 'code' || val === 'preformatted' ? 'pre' : (val === 'list' ? 'ul' : val)));
        const newEl = document.createElement(tag);
        if (val === 'list') newEl.className = 'block-list';
        if (val === 'code') newEl.className = 'code-block';
        if (val === 'preformatted') newEl.className = '';
        newEl.contentEditable = 'true';
        newEl.innerHTML = selectedBlockContent.innerHTML;
        newEl.style.fontSize = selectedBlockContent.style.fontSize;
        newEl.style.color = selectedBlockContent.style.color;
        newEl.style.textAlign = selectedBlockContent.style.textAlign;
        newEl.style.fontWeight = selectedBlockContent.style.fontWeight;
        selectedBlockContent.parentElement.replaceChild(newEl, selectedBlockContent);
        selectedBlockContent = newEl;
        selectedBlock.dataset.type = val === 'paragraph' ? 'paragraph' : (val === 'list' ? 'list' : val === 'code' ? 'code' : val === 'preformatted' ? 'preformatted' : val === 'quote' ? 'quote' : 'heading');
        saveState();
    }

    document.getElementById('tbBlockType').addEventListener('change', (e) => {
        applyBlockTransform(e.target.value);
    });

    document.getElementById('tbTransformBtn').onclick = (e) => {
        e.stopPropagation();
        document.getElementById('tbTransformDropdown').classList.toggle('show');
    };
    document.addEventListener('click', () => document.getElementById('tbTransformDropdown').classList.remove('show'));
    document.getElementById('tbTransformDropdown').onclick = (e) => e.stopPropagation();
    document.querySelectorAll('.tb-transform-option').forEach(btn => {
        btn.onclick = () => {
            const val = btn.dataset.transform;
            const tb = document.getElementById('tbBlockType');
            if (tb && (val === 'paragraph' || val === 'h1' || val === 'h2' || val === 'h3' || val === 'h4' || val === 'quote' || val === 'code' || val === 'list' || val === 'preformatted')) {
                tb.value = val;
                tb.dispatchEvent(new Event('change'));
            } else if (val === 'paragraph' || val === 'h2' || val === 'quote' || val === 'code' || val === 'list' || val === 'preformatted') {
                applyBlockTransform(val);
            }
            document.getElementById('tbTransformDropdown').classList.remove('show');
            syncBlockToolbarFromBlock();
        };
    });

    ['tbAlignLeft', 'tbAlignCenter', 'tbAlignRight'].forEach((id, i) => {
        document.getElementById(id).onclick = () => {
            if (!selectedBlockContent) return;
            const align = ['left', 'center', 'right'][i];
            if (applyImageAlignment(align)) {
                saveState();
                return;
            }
            selectedBlockContent.style.textAlign = align;
            saveState();
        };
    });
    document.getElementById('tbBold').onclick = () => {
        if (selectedBlockContent) {
            document.execCommand('bold');
            saveState();
        }
    };
    document.getElementById('tbItalic').onclick = () => {
        if (selectedBlockContent) {
            document.execCommand('italic');
            saveState();
        }
    };
    document.getElementById('tbFontSize').addEventListener('change', (e) => {
        if (selectedBlockContent) {
            // selectedBlockContent.style.fontSize = e.target.value || '';
            applyFontSize(e.target.value || '');
            saveState();
            document.getElementById('blockFontSize').value = e.target.value;

        }
    });

    // Move block up / down from toolbar
    document.getElementById('tbMoveUp').onclick = () => {
        if (!selectedBlock) return;
        const prev = selectedBlock.previousElementSibling;
        if (prev && prev.classList.contains('block')) {
            editor.insertBefore(selectedBlock, prev);
            saveState();
            refreshAllListViews();
        }
    };
    document.getElementById('tbMoveDown').onclick = () => {
        if (!selectedBlock) return;
        const next = selectedBlock.nextElementSibling;
        if (next && next.classList.contains('block')) {
            editor.insertBefore(next, selectedBlock);
            saveState();
            refreshAllListViews();
        }
    };
    document.getElementById('tbColor').addEventListener('input', (e) => {
        if (selectedBlockContent) {
            selectedBlockContent.style.color = e.target.value;
            saveState();
            document.getElementById('blockColor').value = e.target.value;
        }
    });

    document.getElementById('blockFontSize').addEventListener('change', (e) => {
        if (selectedBlockContent) {
            if (e.target.value === 'custom') return;
            applyFontSize(e.target.value || '');
            saveState();
            document.getElementById('tbFontSize').value = e.target.value;
            // console.log(document.getElementById('tbFontSize').value +"="+ e.target.value)
        }
    });
    document.getElementById('blockFontWeight').addEventListener('change', (e) => {
        if (selectedBlockContent) {
            selectedBlockContent.style.fontWeight = e.target.value;
            saveState();
        }
    });
    document.getElementById('blockColor').addEventListener('input', (e) => {
        if (selectedBlockContent) {
            selectedBlockContent.style.color = e.target.value;
            saveState();
            document.getElementById('tbColor').value = e.target.value;
        }
    });

    function applyImageAlignment(align) {
        if (!selectedBlock || selectedBlock.dataset.type !== 'image') return false;
        const imageWrap = selectedBlock.querySelector('.block-image-inner');
        if (!imageWrap) return false;
        imageWrap.style.display = 'block';
        if (align === 'left') {
            imageWrap.style.marginLeft = '0';
            imageWrap.style.marginRight = 'auto';
        } else if (align === 'center') {
            imageWrap.style.marginLeft = 'auto';
            imageWrap.style.marginRight = 'auto';
        } else if (align === 'right') {
            imageWrap.style.marginLeft = 'auto';
            imageWrap.style.marginRight = '0';
        }
        return true;
    }
    document.getElementById('blockAlignLeft').onclick = () => {
        if (selectedBlockContent) {
            if (applyImageAlignment('left')) {
                saveState();
                return;
            }
            selectedBlockContent.style.textAlign = 'left';
            saveState();
        }
    };
    document.getElementById('blockAlignCenter').onclick = () => {
        if (selectedBlockContent) {
            if (applyImageAlignment('center')) {
                saveState();
                return;
            }
            selectedBlockContent.style.textAlign = 'center';
            saveState();
        }
    };
    document.getElementById('blockAlignRight').onclick = () => {
        if (selectedBlockContent) {
            if (applyImageAlignment('right')) {
                saveState();
                return;
            }
            selectedBlockContent.style.textAlign = 'right';
            saveState();
        }
    };
    document.querySelectorAll('.heading-level-btn').forEach(btn => {
        btn.onclick = () => {
            if (!selectedBlockContent || selectedBlock.dataset.type !== 'heading') return;
            const level = parseInt(btn.dataset.level, 10);
            const tag = 'h' + level;
            const newEl = document.createElement(tag);
            newEl.contentEditable = 'true';
            newEl.innerHTML = selectedBlockContent.innerHTML;
            newEl.style.fontSize = selectedBlockContent.style.fontSize;
            newEl.style.color = selectedBlockContent.style.color;
            newEl.style.textAlign = selectedBlockContent.style.textAlign;
            newEl.style.fontWeight = selectedBlockContent.style.fontWeight;
            selectedBlockContent.parentElement.replaceChild(newEl, selectedBlockContent);
            selectedBlockContent = newEl;
            const tb = document.getElementById('tbBlockType');
            if (tb) tb.value = tag;
            document.querySelectorAll('.heading-level-btn').forEach(b => b.classList.toggle('active', b.dataset.level === btn.dataset.level));
            saveState();
            updateListViewModel();
        };
    });

    // Column controls for font size
    (function() {
        const fontSizeSelect = document.getElementById('blockFontSize');
        const customSlider = document.getElementById('blockFontSizeCustom');
        const customLabel = document.getElementById('blockFontSizeCustomValue');
        if (fontSizeSelect && customSlider && customLabel) {
            fontSizeSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customSlider.style.display = '';
                    customLabel.style.display = '';
                    // Set the slider to the current font size if already set, else default to 16
                    let currentSize = (selectedBlockContent && selectedBlockContent.style.fontSize) ? parseInt(selectedBlockContent.style.fontSize) : 16;
                    if (!isNaN(currentSize)) {
                        customSlider.value = currentSize;
                        customLabel.textContent = currentSize + 'px';
                    } else {
                        customSlider.value = 16;
                        customLabel.textContent = '16px';
                    }
                } else {
                    customSlider.style.display = 'none';
                    customLabel.style.display = 'none';
                }
            });

            customSlider.addEventListener('input', function() {
                customLabel.textContent = this.value + 'px';
                // When changing the custom size, override the block font size accordingly
                if (selectedBlockContent) {
                    // selectedBlockContent.style.fontSize = this.value + 'px';
                    applyFontSize(this.value + 'px');
                    saveState && saveState();
                    // Optionally ensure select's value is custom if not already
                    if (fontSizeSelect.value !== 'custom') {
                        fontSizeSelect.value = 'custom';
                    }
                }
            });
        }
    })();
    // Column controls
    document.getElementById('tbColLayout').onclick = () => {
        if (selectedBlock && (selectedBlock.dataset.type === 'columns' || selectedBlock.dataset.type === 'grid')) {
            document.getElementById('columnLayoutModal').classList.add('show');
        }
    };
    document.getElementById('tbAddCol').onclick = () => {
        if (selectedBlock && (selectedBlock.dataset.type === 'columns' || selectedBlock.dataset.type === 'grid')) {
            const col = document.createElement('div');
            col.className = 'column';
            col.dataset.colIndex = selectedBlock.querySelectorAll('.column').length;
            selectedBlock.appendChild(col);
            const cols = selectedBlock.querySelectorAll('.column').length;
            selectedBlock.dataset.cols = cols;
            if (cols === 1) selectedBlock.dataset.ratio = '100';
            else if (cols === 2) selectedBlock.dataset.ratio = '50-50';
            else if (cols === 3) selectedBlock.dataset.ratio = '33-33-33';
            saveState();
            updateListViewModel();
        }
    };

    // Button controls
    document.getElementById('tbButtonWidth').addEventListener('change', (e) => {
        if (selectedBlock && selectedBlock.dataset.type === 'buttons') {
            const btn = selectedBlock.querySelector('.btn-inline');
            if (btn) {
                btn.style.width = e.target.value;
                saveState();
            }
        }
    });
    document.querySelectorAll('.width-btn').forEach(btn => {
        btn.onclick = () => {
            if (selectedBlock && selectedBlock.dataset.type === 'buttons') {
                const width = btn.dataset.width;
                const buttonEl = selectedBlock.querySelector('.btn-inline');
                if (buttonEl) {
                    buttonEl.style.width = width;
                    document.querySelectorAll('.width-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const tbw = document.getElementById('tbButtonWidth');
                    if (tbw) tbw.value = width;
                    saveState();
                }
            }
        };
    });
    document.getElementById('buttonUrl').addEventListener('input', (e) => {
        if (selectedBlock && selectedBlock.dataset.type === 'buttons') {
            const btn = selectedBlock.querySelector('.btn-inline');
            if (btn) btn.dataset.url = e.target.value;
        }
    });
    document.getElementById('buttonText').addEventListener('input', (e) => {
        if (selectedBlock && selectedBlock.dataset.type === 'buttons') {
            const btn = selectedBlock.querySelector('.btn-inline');
            if (btn) btn.innerText = e.target.value;
        }
    });
    document.getElementById('buttonLinkTarget').addEventListener('change', (e) => {
        if (selectedBlock && selectedBlock.dataset.type === 'buttons') {
            const btn = selectedBlock.querySelector('.btn-inline');
            if (btn) btn.dataset.linkTarget = e.target.value;
        }
    });
    document.getElementById('buttonRel').addEventListener('input', (e) => {
        if (selectedBlock && selectedBlock.dataset.type === 'buttons') {
            const btn = selectedBlock.querySelector('.btn-inline');
            if (btn) btn.dataset.rel = e.target.value;
        }
    });

    // Column layout mini buttons
    document.querySelectorAll('.layout-mini-btn').forEach(btn => {
        btn.onclick = () => {
            if (selectedBlock && (selectedBlock.dataset.type === 'columns' || selectedBlock.dataset.type === 'grid')) {
                const cols = parseInt(btn.dataset.cols, 10);
                const ratio = btn.dataset.ratio;
                const currentCols = selectedBlock.querySelectorAll('.column').length;
                if (cols > currentCols) {
                    for (let i = currentCols; i < cols; i++) {
                        const col = document.createElement('div');
                        col.className = 'column';
                        col.dataset.colIndex = i;
                        selectedBlock.appendChild(col);
                    }
                } else if (cols < currentCols) {
                    const colsToRemove = selectedBlock.querySelectorAll('.column');
                    for (let i = cols; i < colsToRemove.length; i++) {
                        colsToRemove[i].remove();
                    }
                }
                selectedBlock.dataset.cols = cols;
                selectedBlock.dataset.ratio = ratio;
                document.querySelectorAll('.layout-mini-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                saveState();
                updateListViewModel();
            }
        };
    });

    // Collapsible sections
    document.querySelectorAll('.collapsible-toggle').forEach(toggle => {
        toggle.onclick = () => {
            const group = toggle.closest('.settings-group');
            const content = group ? group.querySelector('.collapsible-content') : null;
            if (content) {
                const isExpanded = content.style.display !== 'none';
                content.style.display = isExpanded ? 'none' : 'block';
                toggle.classList.toggle('expanded', !isExpanded);
            }
        };
    });
    document.querySelectorAll('.block-settings-header').forEach(header => {
        header.addEventListener('click', (e) => {
            if (e.target.closest('.block-settings-kebab')) return;
            if (e.target.closest('.collapsible-toggle')) return;
            const toggle = header.querySelector('.collapsible-toggle');
            if (toggle) toggle.click();
        });
    });

    // Dimensions and Border controls
    ['blockWidth', 'blockHeight', 'blockPadding', 'blockMargin'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', (e) => {
                if (selectedBlock && selectedBlockContent) {
                    const value = e.target.value;
                    const prop = id.replace('block', '').toLowerCase();
                    if (prop === 'width') selectedBlockContent.style.width = value || '';
                    else if (prop === 'height') selectedBlockContent.style.height = value || '';
                    else if (prop === 'padding') selectedBlockContent.style.padding = value || '';
                    else if (prop === 'margin') selectedBlockContent.style.margin = value || '';
                    saveState();
                }
            });
        }
    });
    ['blockBorderWidth', 'blockBorderStyle', 'blockBorderColor', 'blockBorderRadius'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', (e) => {
                if (selectedBlock && selectedBlockContent) {
                    const value = e.target.value;
                    if (id === 'blockBorderWidth') selectedBlockContent.style.borderWidth = value ? (value.replace(/[^0-9.]/g, '') ? value : value + 'px') : '';
                    else if (id === 'blockBorderStyle') selectedBlockContent.style.borderStyle = value || '';
                    else if (id === 'blockBorderColor') selectedBlockContent.style.borderColor = value || '';
                    else if (id === 'blockBorderRadius') selectedBlockContent.style.borderRadius = value ? (value.replace(/[^0-9.]/g, '') ? value : value + 'px') : '';
                    saveState();
                }
            });
        }
    });

    // Slider sync for Dimensions/Border (ref: image 1)
    const padSlider = document.getElementById('blockPaddingSlider');
    const padInput = document.getElementById('blockPadding');
    if (padSlider && padInput) {
        padSlider.addEventListener('input', () => {
            padInput.value = padSlider.value;
            if (selectedBlock && selectedBlockContent) {
                selectedBlockContent.style.padding = padSlider.value + 'px';
                saveState();
            }
        });
        padInput.addEventListener('input', () => {
            const n = parseInt(padInput.value, 10);
            if (!isNaN(n)) padSlider.value = Math.min(80, Math.max(0, n));
        });
    }
    const marginSlider = document.getElementById('blockMarginSlider');
    const marginInput = document.getElementById('blockMargin');
    if (marginSlider && marginInput) {
        marginSlider.addEventListener('input', () => {
            marginInput.value = marginSlider.value;
            if (selectedBlock && selectedBlockContent) {
                selectedBlockContent.style.margin = marginSlider.value + 'px';
                saveState();
            }
        });
        marginInput.addEventListener('input', () => {
            const n = parseInt(marginInput.value, 10);
            if (!isNaN(n)) marginSlider.value = Math.min(80, Math.max(0, n));
        });
    }
    const borderWSlider = document.getElementById('blockBorderWidthSlider');
    const borderWInput = document.getElementById('blockBorderWidth');
    if (borderWSlider && borderWInput) {
        borderWSlider.addEventListener('input', () => {
            borderWInput.value = borderWSlider.value;
            if (selectedBlock && selectedBlockContent) {
                selectedBlockContent.style.borderWidth = borderWSlider.value + 'px';
                saveState();
            }
        });
        borderWInput.addEventListener('input', () => {
            const n = parseInt(borderWInput.value, 10);
            if (!isNaN(n)) borderWSlider.value = Math.min(20, Math.max(0, n));
        });
    }
    const radiusSlider = document.getElementById('blockBorderRadiusSlider');
    const radiusInput = document.getElementById('blockBorderRadius');
    if (radiusSlider && radiusInput) {
        radiusSlider.addEventListener('input', () => {
            radiusInput.value = radiusSlider.value;
            if (selectedBlock && selectedBlockContent) {
                selectedBlockContent.style.borderRadius = radiusSlider.value + 'px';
                saveState();
            }
        });
        radiusInput.addEventListener('input', () => {
            const n = parseInt(radiusInput.value, 10);
            if (!isNaN(n)) radiusSlider.value = Math.min(50, Math.max(0, n));
        });
    }

    editor.addEventListener('click', (e) => {
        const block = e.target.closest('.block');
        if (block) {
            // Check if block is in editor or in a column
            const isInEditor = block.parentElement === editor;
            const isInColumn = block.closest('.column');
            if (isInEditor || isInColumn) {
                showBlockToolbar(block);
            }
        } else if (!e.target.closest('.block-toolbar') && !e.target.closest('.slash-menu')) {
            hideBlockToolbar();
        }
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('#editor') && !e.target.closest('.block-toolbar') && !e.target.closest('.wp-right')) {
            hideBlockToolbar();
        }
    });

    // ================= BLOCK TOOLBAR MORE DROPDOWN (ref: image 5) =================
    function showToolbarMore(btn) {
        const moreMenu = document.getElementById('blockToolbarMore');
        const wrapper = document.getElementById('editorWrapper');
        const btnRect = btn.getBoundingClientRect();
        const wrapperRect = wrapper.getBoundingClientRect();
        // Compute position relative to wrapper, similar to toolbar
        moreMenu.style.top = (btnRect.top - wrapperRect.top + btnRect.height + 4) + 'px';
        moreMenu.style.left = (btnRect.left - wrapperRect.left) + 'px';
        moreMenu.classList.add('show');
        // Focus first menu item for accessibility
        const firstBtn = moreMenu.querySelector('button[data-more]');
        if (firstBtn) firstBtn.focus();
    }

    document.getElementById('tbMore').onclick = (e) => {
        e.stopPropagation();
        const moreMenu = document.getElementById('blockToolbarMore');
        if (moreMenu.classList.contains('show')) {
            moreMenu.classList.remove('show');
        } else {
            showToolbarMore(e.currentTarget);
        }
    };
    document.addEventListener('click', () => document.getElementById('blockToolbarMore').classList.remove('show'));
    document.getElementById('blockToolbarMore').onclick = (e) => {
        e.stopPropagation();
    };
    document.querySelectorAll('.block-toolbar-more button[data-more]').forEach(btn => {
        btn.onclick = () => {
            document.getElementById('blockToolbarMore').classList.remove('show');
            const action = btn.dataset.more;
            if (!selectedBlock) return;

            function insertParagraphBefore(target) {
                const b = addParagraph();
                if (b && b.parentNode === editor) {
                    editor.removeChild(b);
                    editor.insertBefore(b, target);
                }
            }

            function insertParagraphAfter(target) {
                const b = addParagraph();
                if (b && b.parentNode === editor) {
                    editor.removeChild(b);
                    editor.insertBefore(b, target.nextSibling);
                }
            }

            switch (action) {
                case 'copy':
                    clipboardBlockJson = blockToJson(selectedBlock);
                    break;
                case 'cut':
                    clipboardBlockJson = blockToJson(selectedBlock);
                    selectedBlock.remove();
                    hideBlockToolbar();
                    break;
                case 'duplicate': {
                    const clone = selectedBlock.cloneNode(true);
                    selectedBlock.parentNode.insertBefore(clone, selectedBlock.nextSibling);
                    reinitializeBlocks();
                    break;
                }
                case 'addBefore':
                    insertParagraphBefore(selectedBlock);
                    break;
                case 'addAfter':
                    insertParagraphAfter(selectedBlock);
                    break;
                case 'addNote': {
                    selectedBlock.dataset.note = prompt('Note for this block:', selectedBlock.dataset.note || '') || '';
                    break;
                }
                case 'copyStyles': {
                    const el = getBlockContentEl(selectedBlock);
                    if (el) {
                        clipboardStyles = {
                            fontSize: el.style.fontSize,
                            color: el.style.color,
                            textAlign: el.style.textAlign,
                            fontWeight: el.style.fontWeight,
                        };
                    }
                    break;
                }
                case 'pasteStyles': {
                    if (!clipboardStyles) break;
                    const el = getBlockContentEl(selectedBlock);
                    if (el) Object.assign(el.style, clipboardStyles);
                    break;
                }
                case 'group': {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'block-group-inner';
                    selectedBlock.parentNode.insertBefore(wrapper, selectedBlock);
                    wrapper.appendChild(selectedBlock);
                    break;
                }
                case 'lock':
                    selectedBlock.dataset.locked = selectedBlock.dataset.locked === '1' ? '0' : '1';
                    break;
                case 'rename':
                    selectedBlock.dataset.label = prompt('Block label:', selectedBlock.dataset.label || getBlockLabel(selectedBlock)) || '';
                    break;
                case 'hide':
                    selectedBlock.classList.toggle('is-hidden');
                    break;
                case 'createPattern':
                    console.log('Block pattern JSON:', blockToJson(selectedBlock));
                    alert('Pattern JSON logged in console.');
                    break;
                case 'editHtml': {
                    const el = getBlockContentEl(selectedBlock);
                    if (!el) break;
                    if (el.tagName !== 'TEXTAREA') {
                        const ta = document.createElement('textarea');
                        ta.style.width = '100%';
                        ta.style.minHeight = '80px';
                        ta.value = el.outerHTML;
                        el.replaceWith(ta);
                        selectedBlockContent = ta;
                    } else {
                        const wrapper = document.createElement('div');
                        wrapper.innerHTML = selectedBlockContent.value;
                        const newEl = wrapper.firstElementChild;
                        if (newEl) {
                            selectedBlockContent.replaceWith(newEl);
                            selectedBlockContent = newEl;
                        }
                    }
                    break;
                }
                case 'delete':
                    selectedBlock.remove();
                    hideBlockToolbar();
                    break;
            }

            saveState();
            refreshAllListViews();
        };
    });

    // ================= FLOATING INSERTER (ref: image 4) =================
    const floatingInserterItems = [{
            name: 'Paragraph',
            icon: '¶',
            block: 'paragraph'
        },
        {
            name: 'Heading 2',
            icon: 'H',
            block: 'heading'
        },
        {
            name: 'Image',
            icon: '🖼',
            block: 'image'
        },
        {
            name: 'Buttons',
            icon: '▢',
            block: 'buttons'
        },
        {
            name: 'Columns',
            icon: '▌',
            block: 'columns',
            cols: 'picker'
        },
        {
            name: 'List',
            icon: '≡',
            block: 'list'
        },
        {
            name: 'Gallery',
            icon: '🖼',
            block: 'image'
        }
    ];

    // Open quick-add popup (ref: image 3) – optionally at a specific insertion context
    function openFloatingInserter(anchorEl, context) {
        insertionContext = context || null;
        const popup = document.getElementById('floatingInserter');
        const wrapper = document.getElementById('editorWrapper');
        renderFloatingInserterGrid();
        const rect = anchorEl.getBoundingClientRect();
        const wr = wrapper.getBoundingClientRect();
        popup.style.top = (rect.bottom - wr.top + 8) + 'px';
        popup.classList.add('show');
        const searchInput = document.getElementById('floatingInserterSearch');
        if (searchInput) {
            searchInput.value = '';
            searchInput.focus();
        }
    }

    function renderFloatingInserterGrid(filterQuery) {
        const grid = document.getElementById('floatingInserterGrid');
        if (!grid) return;
        const q = (filterQuery || '').toLowerCase().trim();
        const items = q ?
            floatingInserterItems.filter(item =>
                item.name.toLowerCase().includes(q) || (item.block || '').toLowerCase().includes(q)) :
            floatingInserterItems;
        grid.innerHTML = items.map(item => {
            return '<div class="fi-item" data-block="' + (item.block || '') + '" data-cols="' + (item.cols || '') + '"><span class="fi-item-icon">' + (item.icon || '') + '</span><span>' + (item.name || '') + '</span></div>';
        }).join('');
        grid.querySelectorAll('.fi-item').forEach(el => {
            el.onclick = () => {
                const blockType = el.dataset.block;
                const cols = el.dataset.cols || undefined;
                const ctx = insertionContext;
                insertionContext = null;
                let newBlock = addBlockByType(blockType, cols === '' ? undefined : cols);
                if (newBlock && newBlock.parentNode === editor) {
                    if (ctx && ctx.afterBlock) {
                        editor.removeChild(newBlock);
                        editor.insertBefore(newBlock, ctx.afterBlock.nextSibling);
                    } else if (ctx && ctx.insideColumn) {
                        editor.removeChild(newBlock);
                        const marker = ctx.marker || ctx.insideColumn.querySelector('.block-insert-marker');
                        ctx.insideColumn.insertBefore(newBlock, marker);
                        attachColumnPlusButtons(ctx.insideColumn);
                    }
                }
                saveState();
                refreshAllListViews();
                document.getElementById('floatingInserter').classList.remove('show');
            };
        });
    }

    document.getElementById('floatingInserterSearch').addEventListener('input', (e) => {
        renderFloatingInserterGrid(e.target.value);
    });

    document.getElementById('floatingInserterBrowseAll').onclick = () => {
        document.getElementById('floatingInserter').classList.remove('show');
        document.querySelector('.wp-layout').classList.remove('sidebar-collapsed');
        document.getElementById('plusToolbarBtn').classList.add('active');
    };

    document.getElementById('editorAddBlockBtn').onclick = (e) => {
        e.stopPropagation();
        openFloatingInserter(document.getElementById('editorAddBlockBtn'), null);
    };

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.floating-inserter') && !e.target.closest('#editorAddBlockBtn') && !e.target.closest('.block-insert-plus')) {
            document.getElementById('floatingInserter').classList.remove('show');
        }
    });

    // ================= WP-LEFT TABS (Blocks / Patterns / Media) =================
    document.querySelectorAll('.wp-left-tab').forEach(tab => {
        tab.onclick = () => {
            document.querySelectorAll('.wp-left-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const id = tab.dataset.tab;
            document.querySelectorAll('.wp-left-tab-content').forEach(c => c.style.display = 'none');
            const el = document.getElementById('wpLeftTab' + id.charAt(0).toUpperCase() + id.slice(1));
            if (el) el.style.display = 'block';
        };
    });

    // ================= PLUS TOOLBAR (block inserter) =================

    document.getElementById('floatingInserterBrowseAll').onclick = () => {
        document.getElementById('floatingInserter').classList.remove('show');
        document.querySelector('.wp-layout').classList.remove('sidebar-collapsed');
        document.getElementById('plusToolbarBtn').classList.add('active');
    };
    document.getElementById('plusToolbarBtn').onclick = () => {
        const layout = document.querySelector('.wp-layout');
        const btn = document.getElementById('plusToolbarBtn');
        layout.classList.toggle('sidebar-collapsed');
        btn.classList.toggle('active', !layout.classList.contains('sidebar-collapsed'));
    };

    // List View button: toggle inline list view panel similar to toolbar inserter
    const listViewBtn = document.getElementById('listViewBtn');
    const listViewPanel = document.getElementById('listViewPanel');
    const listViewClose = document.getElementById('listViewClose');

    if (listViewBtn && listViewPanel) {
        listViewBtn.addEventListener('click', () => {
            const layout = document.querySelector('.wp-layout');
            const plusBtn = document.getElementById('plusToolbarBtn');
            // Ensure left sidebar is visible
            if (layout) layout.classList.remove('sidebar-collapsed');
            if (plusBtn) plusBtn.classList.remove('active');
            const showing = !listViewPanel.classList.contains('show');
            listViewPanel.classList.toggle('show', showing);
            listViewBtn.classList.toggle('active', showing);
            const wpLeft = document.getElementById('wpLeft');
            if (wpLeft) wpLeft.scrollTop = 0;
        });
    }

    if (listViewClose && listViewPanel && listViewBtn) {
        listViewClose.addEventListener('click', () => {
            listViewPanel.classList.remove('show');
            listViewBtn.classList.remove('active');
        });
    }


    // ================= LEFT SIDEBAR: add block by type (click + drag) =================
    function addBlockByType(blockType, extra) {
        if (blockType === 'columns' && (extra === 'picker' || extra === undefined)) {
            document.getElementById('columnLayoutModal').classList.add('show');
            return null;
        }
        const cols = extra && typeof extra === 'number' ? extra : (blockType === 'columns' ? 2 : null);
        let block = null;
        if (blockType === 'paragraph') block = addParagraph();
        else if (blockType === 'heading') block = addHeading(2);
        else if (blockType === 'list') block = addList();
        else if (blockType === 'quote') block = addQuote();
        else if (blockType === 'code') block = addCode();
        else if (blockType === 'preformatted') block = addPreformatted();
        else if (blockType === 'table') block = addTable();
        else if (blockType === 'accordion') block = addAccordion();
        else if (blockType === 'buttons') block = addButtons();
        else if (blockType === 'columns') block = addColumns(cols || 2, extra);
        else if (blockType === 'group') block = addGroup();
        else if (blockType === 'row') block = addRow();
        else if (blockType === 'stack') block = addStack();
        else if (blockType === 'grid') block = addGrid();
        else if (blockType === 'separator') block = addSeparator();
        else if (blockType === 'spacer') block = addSpacer();
        else if (blockType === 'image') block = addImageBlock();
        else if (blockType === 'details') block = addAccordion();
        else if (blockType === 'verse') block = addPreformatted();
        else if (blockType === 'classic') block = addParagraph();
        else if (blockType === 'ai-assistant') block = addParagraph();
        return block || editor.querySelector('.block:last-child');
    }

    document.querySelectorAll('.block-item').forEach(item => {
        item.addEventListener('click', (e) => {
            if (e.target.closest('.block-item')) {
                const blockType = item.dataset.block;
                const cols = item.dataset.cols;
                addBlockByType(blockType, cols === 'picker' ? 'picker' : undefined);
            }
        });
        item.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('application/block-type', item.dataset.block || 'paragraph');
            e.dataTransfer.setData('application/block-cols', item.dataset.cols || '');
            e.dataTransfer.effectAllowed = 'copy';
        });
    });

    document.getElementById('editor').addEventListener('dragover', (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
    });
    document.getElementById('editor').addEventListener('drop', (e) => {
        e.preventDefault();
        const blockType = e.dataTransfer.getData('application/block-type') || 'paragraph';
        const cols = e.dataTransfer.getData('application/block-cols');
        addBlockByType(blockType, cols === 'picker' ? 'picker' : (cols ? parseInt(cols, 10) : undefined));
        refreshAllListViews();
    });

    // Make columns accept nested blocks (drag from sidebar)
    document.addEventListener('dragover', (e) => {
        const column = e.target.closest('.column');
        if (column && !column.closest('.block.dragging')) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy';
            column.style.borderColor = '#3858e9';
        }
    });
    document.addEventListener('dragleave', (e) => {
        const column = e.target.closest('.column');
        if (column) {
            column.style.borderColor = '';
        }
    });
    document.addEventListener('drop', (e) => {
        const column = e.target.closest('.column');
        if (column) {
            e.preventDefault();
            e.stopPropagation();
            column.style.borderColor = '';
            const blockType = e.dataTransfer.getData('application/block-type');
            if (blockType) {
                const block = addBlockByType(blockType);
                if (block && block.parentNode === editor) {
                    editor.removeChild(block);
                    column.appendChild(block);
                    saveState();
                    refreshAllListViews();
                    attachColumnPlusButtons(column);
                }
            }
        }
    });

    // Column layout modal
    document.getElementById('columnLayoutOptions').addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-cols]');
        if (!btn) return;
        const cols = parseInt(btn.dataset.cols, 10);
        const ratio = btn.dataset.ratio || '';
        document.getElementById('columnLayoutModal').classList.remove('show');
        addColumns(cols, ratio);
    });
    document.getElementById('columnLayoutSkip').onclick = () => {
        document.getElementById('columnLayoutModal').classList.remove('show');
        addColumns(2);
    };
    document.getElementById('columnLayoutModal').onclick = (e) => {
        if (e.target.id === 'columnLayoutModal') e.target.classList.remove('show');
    };

    // ================= TOP BAR FEATURES =================
    // List View button highlight (inline panel is always visible)
    document.getElementById('listViewBtn').onclick = () => {
        const layout = document.querySelector('.wp-layout');
        const plusBtn = document.getElementById('plusToolbarBtn');
        // Ensure sidebar is open, but plus button is not highlighted
        layout.classList.remove('sidebar-collapsed');
        if (plusBtn) {
            plusBtn.classList.remove('active');
        }
        // Scroll left panel so List View is visible
        document.getElementById('wpLeft').scrollTop = 0;
    };
    document.getElementById('listViewClose').onclick = () => {
        // no-op in inline mode, kept for compatibility
    };

    document.getElementById('undoBtn').onclick = undo;
    document.getElementById('redoBtn').onclick = redo;

    document.getElementById('commandPaletteBtn').onclick = () => {
        document.getElementById('commandPaletteModal').classList.add('show');
        document.getElementById('commandPaletteInput').focus();
    };

    document.getElementById('commandPaletteInput').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.command-palette-item');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(query) ? 'block' : 'none';
        });
    });

    document.getElementById('commandPaletteModal').onclick = (e) => {
        if (e.target.id === 'commandPaletteModal') {
            document.getElementById('commandPaletteModal').classList.remove('show');
        }
    };
    document.querySelectorAll('.command-palette-item').forEach(item => {
        item.onclick = () => {
            const t = (item.textContent || '').toLowerCase();
            document.getElementById('commandPaletteModal').classList.remove('show');
            if (t.includes('paragraph')) addParagraph();
            else if (t.includes('heading')) addHeading(2);
            else if (t.includes('list')) addList();
            else if (t.includes('quote')) addQuote();
            else if (t.includes('code')) addCode();
            else if (t.includes('image')) addImageBlock();
            else if (t.includes('columns')) document.getElementById('columnLayoutModal').classList.add('show');
            else if (t.includes('undo')) undo();
            else if (t.includes('redo')) redo();
            else if (t.includes('draft')) document.getElementById('saveDraftBtn').click();
            else if (t.includes('preview')) document.getElementById('previewBtn').click();
        };
    });


    document.getElementById('closePreviewBtn').onclick = () => {
        document.getElementById('previewModal').classList.remove('show');
    };

    document.querySelectorAll('.preview-device button').forEach(btn => {
        btn.onclick = () => {
            document.querySelectorAll('.preview-device button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const device = btn.dataset.device;
            const frame = document.getElementById('previewFrame');
            frame.className = 'preview-frame ' + device;
        };
    });

    // ================= POST NAME UPDATE =================
    function updatePostName() {
        const postName = title.value.trim() || 'No title';
        document.getElementById('postName').textContent = postName + ' • Post';
    }

    title.addEventListener('input', () => {
        updatePostName();
        updateLastEdited();
    });

    // ================= RIGHT SIDEBAR SETTINGS =================
    document.getElementById('featuredImageBtn').onclick = () => {
        document.getElementById('featuredImageInput').click();
    };

    document.getElementById('featuredImageInput').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const img = document.createElement('img');
                img.src = event.target.result;
                const btn = document.getElementById('featuredImageBtn');
                btn.innerHTML = '';
                btn.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelectorAll('input[name="status"]').forEach(radio => {
        radio.addEventListener('change', () => {
            const statusField = document.querySelector('[name=status]');
            const checked = document.querySelector('input[name="status"]:checked');
            if (statusField && checked) statusField.value = checked.value;

        });
    });

    // Topbar settings (Post/Block sidebar) toggle
    const settingsSidebarBtn = document.getElementById('settingsSidebarBtn');
    settingsSidebarBtn.onclick = () => {
        const layout = document.querySelector('.wp-layout');
        const collapsed = layout.classList.toggle('right-collapsed');
        settingsSidebarBtn.classList.toggle('active', !collapsed);
    };

    document.getElementById('publishTiming').onclick = () => {
        document.getElementById('publishTiming').style.display = 'none';
        document.getElementById('publishTimingInput').style.display = 'block';
        document.getElementById('scheduleDate').focus();
    };

    document.getElementById('slugValue').onclick = () => {
        document.getElementById('slugValue').style.display = 'none';
        document.getElementById('slugInput').style.display = 'block';
        document.getElementById('slugInput').value = title.value.toLowerCase().replace(/\s+/g, '-');
        document.getElementById('slugInput').focus();
    };

    document.getElementById('slugInput').addEventListener('blur', () => {
        const value = document.getElementById('slugInput').value;
        if (value) {
            document.getElementById('slugValue').textContent = value;
        }
        document.getElementById('slugValue').style.display = 'block';
        document.getElementById('slugInput').style.display = 'none';
    });

    document.getElementById('authorValue').onclick = () => {
        document.getElementById('authorValue').style.display = 'none';
        document.getElementById('authorSelect').style.display = 'block';
        document.getElementById('authorSelect').focus();
    };

    document.getElementById('authorSelect').addEventListener('change', (e) => {
        document.getElementById('authorValue').textContent = e.target.value;
        document.getElementById('authorValue').style.display = 'block';
        document.getElementById('authorSelect').style.display = 'none';
    });

    document.querySelectorAll('.settings-tabs button').forEach(btn => {
        btn.onclick = () => {
            document.querySelectorAll('.settings-tabs button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const tab = btn.dataset.tab;
            document.getElementById('postSettings').style.display = tab === 'post' ? 'block' : 'none';
            document.getElementById('blockSettings').style.display = tab === 'block' ? 'block' : 'none';
        };
    });

    function updateLastEdited() {
        // console.log("updateLastEdited");
        lastEditedTime = new Date();
        const minutes = Math.floor((new Date() - lastEditedTime) / 60000);
        let text = 'Just now';
        if (minutes > 0) {
            text = minutes === 1 ? '1 minute ago' : `${minutes} minutes ago`;
        }
        document.getElementById('lastEdited').textContent = text;
    }

    // ================= SAVE & PUBLISH =================
    // Strip editor-only UI so plus symbols, drag handles, etc. are not saved to DB (ref: image 2)
    function cleanHTML(html) {
        const div = document.createElement('div');
        div.innerHTML = html;

        div.querySelectorAll('[contenteditable]').forEach(el => {
            el.removeAttribute('contenteditable');
            el.removeAttribute('data-placeholder');
        });

        // Remove block toolbar UI elements that must not be persisted
        div.querySelectorAll('.block-drag-handle, .block-controls, .block-insert-marker, .block-insert-marker-bottom').forEach(el => {
            el.remove();
        });

        return div.innerHTML;
    }

    function isBase64Image(src) {
        return src && src.startsWith('data:image');
    }

    function base64ToFile(base64) {
        const arr = base64.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);

        while (n--) u8arr[n] = bstr.charCodeAt(n);

        return new File([u8arr], 'image.jpg', {
            type: mime
        });
    }

    async function uploadImage(file, pageName) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('page_name', pageName);

        const response = await fetch('{{ route("admin.blogs.uploadImage") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });

        if (!response.ok) {
            const text = await response.text();
            console.error(text);
            throw new Error('Image upload failed');
        }

        const data = await response.json();
        return data.url;
    }

    // Validate required fields before saving or publishing, including block fields
    function validateFormFields(blocksRaw) {
        let errors = [];

        // Title
        const titleValue = title.value.trim();
        if (!titleValue) {
            errors.push("Title is required.");
        }

        // Slug (auto-generate from title if empty)
        const slugInput = document.getElementById('slugInput');
        let slugValue = (slugInput && slugInput.value) ? slugInput.value.trim() : '';
        if (!slugValue && titleValue) {
            slugValue = slugify(titleValue);
            if (slugInput) slugInput.value = slugValue;
            const slugValueLabel = document.getElementById('slugValue');
            if (slugValueLabel && slugValueLabel.textContent === 'auto-generated') {
                slugValueLabel.textContent = slugValue;
            }
        }
        if (!slugValue) {
            errors.push("Slug is required.");
        }

        // Author
        const authorSelect = document.getElementById('authorSelect');
        const authorValue = (authorSelect && authorSelect.value) ? authorSelect.value.trim() : '';
        if (!authorValue) {
            errors.push("Author is required.");
        }

        // Content Blocks
        if (!blocksRaw || blocksRaw.length === 0) {
            errors.push("At least one content block is required.");
        } else {
            // Validate Heading, Paragraph, List, etc not empty
            for (const [i, b] of blocksRaw.entries()) {
                const type = b.dataset.type;
                // Checks for block types that should have content
                if (
                    ['heading', 'paragraph', 'list', 'blockquote', 'code', 'preformatted'].includes(type)
                ) {
                    // Prefer contenteditable, fallback to text content or innerHTML
                    let el = b.querySelector('[contenteditable]') ||
                        b.querySelector('h1,h2,h3,h4,h5,h6,p,li,blockquote,pre,div');
                    let content = el ? (el.textContent || '').trim() : '';
                    if (!content) {
                        errors.push(
                            type.charAt(0).toUpperCase() +
                            type.slice(1) +
                            " block at position " + (i + 1) +
                            " cannot be blank."
                        );
                    }
                }
                if (type === 'image') {
                    const img = b.querySelector('img');
                    if (!img || !img.getAttribute('src')) {
                        errors.push("Image block at position " + (i + 1) + " cannot be blank.");
                    }
                }
                if (type === 'accordion') {
                    b.querySelectorAll('.block-accordion-item').forEach((item, itemIdx) => {
                        let titleText = (item.querySelector('.block-accordion-title')?.textContent || '').trim();
                        let bodyText = (item.querySelector('[contenteditable]')?.textContent || '').trim();
                        if (!titleText) {
                            errors.push("Accordion #" + (i + 1) + " item #" + (itemIdx + 1) + " title cannot be blank.");
                        }
                        if (!bodyText) {
                            errors.push("Accordion #" + (i + 1) + " item #" + (itemIdx + 1) + " body cannot be blank.");
                        }
                    });
                }
                // You can add more block type checks if you want
            }
        }

        return errors;
    }

    async function saveContent(publish = false) {
        const blocksRaw = Array.from(editor.children).filter(el => el.classList.contains('block'));
        const validationErrors = validateFormFields(blocksRaw);

        if (validationErrors.length > 0) {
            alert("Please fix the following errors before continuing:\n- " + validationErrors.join("\n- "));
            return;
        }

        const blocks = [];
        const pageTitle = title.value.trim() || 'blog';

        for (const b of blocksRaw) {
            const type = b.dataset.type;

            /* ===============================
               Columns / Grid
            =============================== */
            if (type === 'columns' || type === 'grid') {
                const cols = [];
                b.querySelectorAll('.column').forEach(c => {
                    cols.push(cleanHTML(c.innerHTML));
                });
                blocks.push({
                    type: type,
                    columns: cols,
                    ratio: b.dataset.ratio || ''
                });
            }

            /* ===============================
               Image (Base64 → Upload → URL)
            =============================== */
            else if (type === 'image') {
                const img = b.querySelector('img');
                if (!img) continue;

                let src = img.getAttribute('src');

                // If Base64, upload first
                if (isBase64Image(src)) {
                    const file = base64ToFile(src);
                    src = await uploadImage(file, pageTitle);

                    // Replace Base64 in editor
                    img.setAttribute('src', src);
                }

                blocks.push({
                    type: 'image',
                    url: src
                });
            }

            /* ===============================
               Spacer / Separator
            =============================== */
            else if (type === 'spacer' || type === 'separator') {
                blocks.push({
                    type: type
                });
            }

            /* ===============================
               Accordion
            =============================== */
            else if (type === 'accordion') {
                const items = [];
                b.querySelectorAll('.block-accordion-item').forEach(item => {
                    items.push({
                        title: (item.querySelector('.block-accordion-title')?.textContent || '').trim(),
                        body: (item.querySelector('[contenteditable]')?.innerHTML || '').trim()
                    });
                });

                blocks.push({
                    type: 'accordion',
                    items: items
                });
            }

            /* ===============================
               Everything Else (including heading, list, etc)
            =============================== */
            else {
                // Get the editable or semantic block in priority order
                let el =
                    b.querySelector('[contenteditable]') ||
                    b.querySelector('h1, h2, h3, h4, h5, h6') ||
                    b.querySelector('ul,ol,li,p,blockquote,pre,div');

                let content = '';
                if (el) {
                    // Example for handling provided content: Remove span wrappers, inline styles, but preserve semantic structure
                    let clone = el.cloneNode(true);

                    function cleanElement(element) {
                        // Remove all style attributes and unwanted classes
                        if (element.removeAttribute) {
                            element.removeAttribute('style');
                            element.removeAttribute('class');
                        }

                        // Flatten <span> tags but keep their content
                        if (element.tagName === 'SPAN' && element.childNodes.length > 0) {
                            // Move children up
                            let parent = element.parentNode;
                            while (element.firstChild) {
                                parent.insertBefore(element.firstChild, element);
                            }
                            parent.removeChild(element);
                            return;
                        }

                        // Recursively clean children, make a static copy since the tree may mutate
                        let children = Array.from(element.childNodes);
                        for (let child of children) {
                            if (child.nodeType === 1) { // Element node
                                cleanElement(child);
                            }
                        }
                    }

                    // Remove redundant inline <h4> wrappers matching the broken pattern
                    if (
                        clone.tagName &&
                        /^H[1-6]$/.test(clone.tagName) &&
                        clone.previousElementSibling &&
                        clone.previousElementSibling.tagName === 'H4' &&
                        clone.previousElementSibling.innerHTML.trim() === ''
                    ) {
                        clone.previousElementSibling.remove();
                    }

                    // Normalize broken <h2> structure if possible
                    if (clone.tagName === 'H2') {
                        // Remove all internal span wrappers and inline style attributes
                        // to provide clean H2 with only text content
                        cleanElement(clone);
                        clone.innerHTML = clone.innerText;
                        content = cleanHTML(clone.outerHTML);
                    } else {
                        cleanElement(clone);
                        content = cleanHTML(clone.outerHTML);
                    }
                }

                // Remove empty content blocks for types that matter
                if (
                    ['heading', 'paragraph', 'list', 'blockquote', 'code', 'preformatted'].includes(type) &&
                    (!el || !el.textContent.trim())
                ) continue;

                blocks.push({
                    type: type,
                    content: content
                });
            }
        }

        // Assign to form
        document.querySelector('[name=title]').value = title.value.trim();
        document.querySelector('[name=content]').value = JSON.stringify(blocks);

        // Save additional fields (slug, author)
        const slugInput = document.getElementById('slugInput');
        const slugField = document.querySelector('[name=slug]');
        if (slugInput && slugField) {
            slugField.value = slugInput.value.trim();
        } else if (slugInput) {
            // If slug field doesn't exist, add new hidden input for slug
            let newSlugInput = document.createElement('input');
            newSlugInput.type = 'hidden';
            newSlugInput.name = 'slug';
            newSlugInput.value = slugInput.value.trim();
            document.getElementById('saveForm').appendChild(newSlugInput);
        }

        const authorSelect = document.getElementById('authorSelect');
        const authorField = document.querySelector('[name=author]');
        if (authorSelect && authorField) {
            authorField.value = authorSelect.value.trim();
        } else if (authorSelect) {
            // If author field doesn't exist, add new hidden input for author
            let newAuthorInput = document.createElement('input');
            newAuthorInput.type = 'hidden';
            newAuthorInput.name = 'author';
            newAuthorInput.value = authorSelect.value.trim();
            document.getElementById('saveForm').appendChild(newAuthorInput);
        }
        const featuredInput = document.getElementById('featuredImageInput');
        const featuredBtn = document.getElementById('featuredImageBtn');
        const referenceField = document.querySelector('[name=reference_image]');
        const ensureReferenceField = () => {
            if (referenceField) return referenceField;
            const newRefInput = document.createElement('input');
            newRefInput.type = 'hidden';
            newRefInput.name = 'reference_image';
            document.getElementById('saveForm').appendChild(newRefInput);
            return newRefInput;
        };
        const setReferenceImage = async () => {
            const refField = ensureReferenceField();
            if (featuredInput && featuredInput.files && featuredInput.files[0]) {
                const uploaded = await uploadImage(featuredInput.files[0], pageTitle);
                refField.value = uploaded;
                return;
            }
            const featuredImg = featuredBtn ? featuredBtn.querySelector('img') : null;
            if (featuredImg && featuredImg.getAttribute('src')) {
                let src = featuredImg.getAttribute('src');
                if (isBase64Image(src)) {
                    const file = base64ToFile(src);
                    src = await uploadImage(file, pageTitle);
                }
                refField.value = src;
            }
        };

        await setReferenceImage();

        const categorySelect = document.getElementById('categorySelect');
        const categoryField = document.querySelector('[name=category_id]');
        if (categorySelect && categoryField) {
            categoryField.value = categorySelect.value;
        } else if (categorySelect) {
            let newCategoryInput = document.createElement('input');
            newCategoryInput.type = 'hidden';
            newCategoryInput.name = 'category_id';
            newCategoryInput.value = categorySelect.value;
            document.getElementById('saveForm').appendChild(newCategoryInput);
        }

        const tagsInput = document.getElementById('tagsInput');
        const tagsField = document.querySelector('[name=tags]');
        if (tagsInput && tagsField) {
            tagsField.value = tagsInput.value.trim();
        } else if (tagsInput) {
            let newTagsInput = document.createElement('input');
            newTagsInput.type = 'hidden';
            newTagsInput.name = 'tags';
            newTagsInput.value = tagsInput.value.trim();
            document.getElementById('saveForm').appendChild(newTagsInput);
        }

        /* ===============================
           Debug
        =============================== */
        console.log('===== EDITOR BLOCK OUTPUT =====');
        console.log(blocks);
        console.log('===== JSON STRING =====');
        console.log(JSON.stringify(blocks, null, 2));
        // return;
        // Handle Publish and Draft success alert after form submit.
        // Use form submission event and a temporary flag.
        const saveForm = document.getElementById('saveForm');
        let alreadyAlerted = false;
        saveForm.onsubmit = function(e) {
            // This handler may run multiple times, avoid duplicate alert
            if (!alreadyAlerted) {
                alreadyAlerted = true;
                setTimeout(() => {
                    alreadyAlerted = false;
                }, 500);
                // Visual feedback is handled by SweetAlert after the
                // request completes using Laravel flash messages.
            }
        };
        // Set status (if you use it in backend)
        const statusField = document.querySelector('[name=status]');
        const checkedStatus = document.querySelector('input[name="status"]:checked');
        if (statusField) {
            if (publish) {
                statusField.value = 'active';
            } else if (checkedStatus) {
                statusField.value = checkedStatus.value;
            } else {
                statusField.value = 'inactive';
            }
        }
        saveForm.submit();
    }

    document.getElementById('publishBtn').onclick = () => {
        saveContent(true);
    };

    document.getElementById('previewBtn').onclick = () => {
        showPreview();
    };

    function showPreview() {
        const previewContent = document.getElementById('previewContent');
        const titleText = title.value || 'No title';
        let html = `<h1>${titleText}</h1>`;

        document.querySelectorAll('#editor .block').forEach(b => {
            const type = b.dataset.type;
            if (type === 'columns' || type === 'grid') {
                const ratio = b.dataset.ratio;
                let gridCols = 'repeat(' + (b.dataset.cols || 2) + ', 1fr)';
                if (ratio === '33-66') gridCols = '1fr 2fr';
                else if (ratio === '66-33') gridCols = '2fr 1fr';
                else if (ratio === '25-50-25') gridCols = '1fr 2fr 1fr';
                html += '<div style="display: grid; grid-template-columns: ' + gridCols + '; gap: 24px; margin: 20px 0;">';
                b.querySelectorAll('.column').forEach(c => {
                    html += '<div>' + c.innerHTML + '</div>';
                });
                html += '</div>';
            } else if (type === 'image') {
                const img = b.querySelector('.block-image-inner img');
                if (img) html += '<div style="margin:20px 0">' + img.outerHTML + '</div>';
            } else if (type === 'separator') {
                html += ' <hr style = "margin:20px 0;border:none;border-top:1px solid #dcdcde" > ';
            } else if (type === 'spacer') {
                html += '<div style="height:40px"></div>';
            } else if (type === 'accordion') {
                b.querySelectorAll('.block-accordion-item').forEach(item => {
                    const body = item.querySelector('.block-accordion-body');
                    if (body) html += '<div style="margin:12px 0">' + body.innerHTML + '</div>';
                });
            } else if (type === 'buttons') {
                const inner = b.querySelector('.block-buttons-inner');
                if (inner) html += '<div style="margin:20px 0">' + inner.innerHTML + '</div>';
            } else {
                const content = b.querySelector('[contenteditable]') || b.querySelector('h1, h2, h3, h4, blockquote, pre, ul, ol') || b.children[2];
                if (content) html += '<div>' + content.outerHTML + '</div>';
            }
        });

        previewContent.innerHTML = html;
        document.getElementById('previewModal').classList.add('show');
    }

    // ================= LEFT SIDEBAR SEARCH =================
    document.getElementById('blockSearch').addEventListener('input', (e) => {
        const q = (e.target.value || '').toLowerCase();
        document.querySelectorAll('.wp-left .block-item').forEach(item => {
            const text = (item.querySelector('.block-item-text') || item).textContent.toLowerCase();
            item.style.display = q ? (text.includes(q) ? 'flex' : 'none') : 'flex';
        });
    });

    // ================= EXPOSE FOR INLINE / GLOBAL =================
    window.addParagraph = addParagraph;
    window.addHeading = addHeading;
    window.addList = addList;
    window.addQuote = addQuote;
    window.addCode = addCode;
    window.addPreformatted = addPreformatted;
    window.addTable = addTable;
    window.addAccordion = addAccordion;
    window.addButtons = addButtons;
    window.addColumns = addColumns;
    window.addGroup = addGroup;
    window.addRow = addRow;
    window.addStack = addStack;
    window.addGrid = addGrid;
    window.addSeparator = addSeparator;
    window.addSpacer = addSpacer;
    window.addImageBlock = addImageBlock;
    window.removeBlock = removeBlock;

    // ================= RESTORE EXISTING CONTENT (EDIT MODE) =================
    function loadInitialBlocks(blocksData) {
        // Fix: ensure all content including headings aren't missing in edit mode
        if (!Array.isArray(blocksData) || !blocksData.length) return;
        editor.innerHTML = '';

        blocksData.forEach(b => {
            const type = b.type || 'paragraph';
            console.log('Block type:', type, '| Data:', b);

            if (type === 'columns' || type === 'grid') {
                console.log('Processing columns/grid:', b);
                const colsCount = (b.columns && b.columns.length) ? b.columns.length : parseInt(b.cols || 2, 10) || 2;
                const wrap = document.createElement('div');
                wrap.className = 'columns';
                wrap.dataset.cols = colsCount;
                if (b.ratio) wrap.dataset.ratio = b.ratio;
                for (let i = 0; i < colsCount; i++) {
                    const col = document.createElement('div');
                    col.className = 'column';
                    col.dataset.colIndex = i;
                    if (b.columns && b.columns[i]) {
                        col.innerHTML = b.columns[i];
                    }
                    wrap.appendChild(col);
                }
                const block = wrapBlock(wrap, type);
                attachColumnPlusButtons(block);
            } else if (type === 'image') {
                console.log('Processing image:', b);
                const wrap = document.createElement('div');
                wrap.className = 'block-image-inner has-image';
                const url = b.url || '';
                if (!url) {
                    console.log('No image url found for this block:', b);
                    return;
                }
                wrap.innerHTML = '<img src="' + url + '" alt="">';
                wrapBlock(wrap, 'image');
            } else if (type === 'separator') {
                console.log('Processing separator:', b);
                addSeparator();
            } else if (type === 'spacer') {
                console.log('Processing spacer:', b);
                addSpacer();
            } else if (type === 'accordion') {
                console.log('Processing accordion:', b);
                const wrap = document.createElement('div');
                wrap.className = 'block-accordion';
                const items = Array.isArray(b.items) ? b.items : [];
                items.forEach(item => {
                    console.log('Accordion item:', item);
                    const accItem = document.createElement('div');
                    accItem.className = 'block-accordion-item';
                    const title = document.createElement('div');
                    title.className = 'block-accordion-title';
                    const titleText = document.createElement('span');
                    titleText.contentEditable = true;
                    titleText.innerText = (item.title || '').trim() || 'Accordion title';
                    const toggle = document.createElement('span');
                    toggle.className = 'accordion-toggle';
                    toggle.textContent = '+';
                    toggle.style.cursor = 'pointer';
                    toggle.style.userSelect = 'none';
                    title.appendChild(titleText);
                    title.appendChild(toggle);
                    const body = document.createElement('div');
                    body.className = 'block-accordion-body';
                    body.style.display = 'none';
                    const content = document.createElement('div');
                    content.contentEditable = true;
                    content.setAttribute('data-placeholder', 'Content');
                    content.innerHTML = (item.body || '').trim() || 'Content here';
                    body.appendChild(content);
                    accItem.appendChild(title);
                    accItem.appendChild(body);
                    wrap.appendChild(accItem);
                    toggle.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const isOpen = body.style.display !== 'none';
                        body.style.display = isOpen ? 'none' : 'block';
                        toggle.textContent = isOpen ? '+' : '−';
                    });
                });
                wrapBlock(wrap, 'accordion');
            } else {
                // Enhanced handling for broken heading HTML (e.g., <h4 ...></h4><h2 ...>...</h2>)
                let el;
                if (b.content) {
                    console.log('Processing default/other block:', type, b);
                    const tmp = document.createElement('div');
                    tmp.innerHTML = b.content;

                    if (type === 'heading') {
                        // Special: Remove empty <h4> before <h2>, normalize <h2> for text/clean html
                        // Case: <h4 style="font-size: 12px;"></h4><h2 ...><span>...</span></h2>
                        let h2 = tmp.querySelector('h2');
                        // Remove empty preceding <h4> if pattern matches
                        if (
                            h2 &&
                            h2.previousElementSibling &&
                            h2.previousElementSibling.tagName === 'H4' &&
                            h2.previousElementSibling.textContent.trim() === ''
                        ) {
                            h2.previousElementSibling.remove();
                        }
                        // After cleaning, fetch highest-ranking heading (h1 > h2 > ...)
                        let headingEl = tmp.querySelector('h1, h2, h3, h4, h5, h6');
                        if (!headingEl) {
                            headingEl = tmp.firstElementChild;
                        }
                        // Normalize innerHTML: remove nested span/style for clean output
                        if (headingEl) {
                            // Remove all <span> and inline style from the heading
                            headingEl.innerHTML = headingEl.innerText;
                            headingEl.removeAttribute('style');
                            el = headingEl.cloneNode(true);
                        } else {
                            el = document.createElement('h2');
                        }
                        el.contentEditable = 'true';
                    } else {
                        el = tmp.firstElementChild || tmp;
                        if (['heading', 'paragraph', 'list', 'blockquote', 'code', 'preformatted'].includes(type)) {
                            el.contentEditable = 'true';
                        }
                        if (type === 'list') el.classList.add('block-list');
                        if (type === 'code') el.classList.add('code-block');
                    }
                    wrapBlock(el, type);
                } else {
                    console.log('No content found for', type, b);
                }
            }
        });

        reinitializeBlocks();
        attachColumnPlusButtons(document);
        saveState();
        refreshAllListViews();
    }

    // ================= INITIALIZE =================
    const initialContentEl = document.getElementById('initialBlogContent');
    const isEditMode = !!initialContentEl;
    if (isEditMode && initialContentEl && initialContentEl.value) {
        try {
            const parsedBlocks = JSON.parse(initialContentEl.value);
            loadInitialBlocks(parsedBlocks);
        } catch (e) {
            console.error('Failed to parse initial blog content', e);
        }
    }

    if (!editor.querySelector('.block')) {
        // Initial command input block: “Type / to choose a block”
        const firstBlock = addParagraph();
        const content = firstBlock && firstBlock.querySelector('[contenteditable]');
        if (content) {
            content.setAttribute('data-placeholder', 'Type / to choose a block');
            content.focus();
        }
    }

    saveState();
    updatePostName();
    updateLastEdited();
    refreshAllListViews();

    // Close menus when clicking outside
    document.addEventListener('click', (e) => {
        // no slide-out list view anymore, only inline; keep slash-menu close behavior
        if (!e.target.closest('.slash-menu') && !e.target.closest('[contenteditable]')) {
            hideSlashMenu();
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            document.getElementById('commandPaletteBtn').click();
        }
        if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
            e.preventDefault();
            undo();
        }
        if ((e.ctrlKey || e.metaKey) && (e.key === 'y' || (e.key === 'z' && e.shiftKey))) {
            e.preventDefault();
            redo();
        }
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            document.getElementById('saveDraftBtn').click();
        }
    });
</script>

<!-- SweetAlert2 for nicer success/error toasts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: "{{ addslashes(session('success')) }}",
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: "{{ addslashes(session('error')) }}",
        toast: true,
        position: 'top-end',
        timer: 4000,
        showConfirmButton: false
    });
</script>
@endif

@endsection