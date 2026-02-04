<?php

if (! function_exists('renderBlock')) {

    function renderBlock(array $block): string
    {
        switch ($block['type'] ?? '') {

            case 'paragraph':
                return '<p>' . nl2br(e(trim($block['content'] ?? ''))) . '</p>';

            case 'heading':
                $text = trim($block['content'] ?? '');
                if ($text === '') return '';
                return '<h2>' . e($text) . '</h2>';

            case 'list':
                $lines = array_filter(
                    array_map('trim', explode("\n", $block['content'] ?? ''))
                );

                if (empty($lines)) return '';

                $html = '<ul>';
                foreach ($lines as $line) {
                    $html .= '<li>' . e($line) . '</li>';
                }
                $html .= '</ul>';

                return $html;

            case 'image':
                if (empty($block['url'])) return '';
                return '<img src="' . asset(ltrim($block['url'], '/')) . '" alt="">';

            case 'separator':
                return '<hr>';

            case 'spacer':
                return '<div style="height:32px"></div>';

            case 'columns':
                if (empty($block['columns'])) return '';
                $cols = count($block['columns']);

                $html = '<div class="wp-columns" data-cols="'.$cols.'">';
                foreach ($block['columns'] as $col) {
                    $html .= '<div>'.$col.'</div>';
                }
                $html .= '</div>';

                return $html;

            case 'accordion':
                if (empty($block['items'])) return '';

                $html = '<div class="wp-accordion">';
                foreach ($block['items'] as $item) {
                    $html .= '<details>';
                    $html .= '<summary>'.e($item['title']).'</summary>';
                    $html .= '<div>'.$item['body'].'</div>';
                    $html .= '</details>';
                }
                $html .= '</div>';

                return $html;

            default:
                return '';
        }
    }
}
