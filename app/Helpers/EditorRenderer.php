<?php

if (!function_exists('renderEditorContent')) {
    function renderEditorContent(?string $json): string
    {
        if (!$json) {
            return '';
        }

        $blocks = json_decode($json, true);

        if (!is_array($blocks)) {
            return '';
        }

        $html = '';

        foreach ($blocks as $block) {

            // Columns / Grid need wrapper
            if (in_array($block['type'], ['columns', 'grid'])) {

                $html .= '<div class="editor-columns">';

                foreach ($block['columns'] ?? [] as $col) {
                    $html .= '<div class="editor-column">' . $col . '</div>';
                }

                $html .= '</div>';

            } else {
                // Everything else prints as-is
                $html .= $block['content'] ?? '';
            }
        }

        return $html;
    }
}
