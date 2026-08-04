<?php
// Synergy Group Theme Functions
if (!function_exists('synergy_theme_setup')) {
    function synergy_theme_setup() {
        if (function_exists('add_theme_support')) {
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
        }
    }
    if (function_exists('add_action')) {
        add_action('after_setup_theme', 'synergy_theme_setup');
    }
}

// Cache-busting URL for theme assets: /components/style.css -> .../components/style.css?v=1712345678
if (!function_exists('synergy_asset')) {
    function synergy_asset($relative_path) {
        $relative_path = '/' . ltrim($relative_path, '/');
        $base_dir = function_exists('get_template_directory') ? get_template_directory() : __DIR__;
        $base_url = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
        $file = $base_dir . $relative_path;
        $url  = $base_url . $relative_path;
        return file_exists($file) ? $url . '?v=' . filemtime($file) : $url;
    }
}

if (!function_exists('synergy_theme_scripts')) {
    function synergy_theme_scripts() {
        $base_dir = function_exists('get_stylesheet_directory') ? get_stylesheet_directory() : __DIR__;
        $style_uri = function_exists('get_stylesheet_uri') ? get_stylesheet_uri() : './style.css';
        $style_path = $base_dir . '/style.css';
        $style_ver  = file_exists($style_path) ? filemtime($style_path) : null;
        if (function_exists('wp_enqueue_style')) {
            wp_enqueue_style('synergy-style', $style_uri, array(), $style_ver);
        }
    }
    if (function_exists('add_action')) {
        add_action('wp_enqueue_scripts', 'synergy_theme_scripts');
    }
}

if (!function_exists('synergy_content')) {
    function synergy_content($key, $default = '', $page = 'about') {
        static $cached_data = [];
        if (!isset($cached_data[$page])) {
            $base_dir = function_exists('get_template_directory') ? get_template_directory() : __DIR__;
            $dataFile = $base_dir . '/data/content_' . preg_replace('/[^a-z0-9_-]/i', '', $page) . '.json';
            if (file_exists($dataFile)) {
                $cached_data[$page] = json_decode(file_get_contents($dataFile), true) ?: [];
            } else {
                $cached_data[$page] = [];
            }
        }
        return isset($cached_data[$page][$key]) ? $cached_data[$page][$key] : $default;
    }
}

if (!function_exists('synergy_style')) {
    function synergy_style($key, $page = 'about') {
        $pos = synergy_content($key . '_pos', null, $page);
        $size = synergy_content($key . '_size', null, $page);
        
        $styles = [];
        if (is_array($pos) && (isset($pos['x']) || isset($pos['y']))) {
            $x = intval($pos['x'] ?? 0);
            $y = intval($pos['y'] ?? 0);
            if ($x !== 0 || $y !== 0) {
                $styles[] = "position: relative; left: {$x}px; top: {$y}px;";
            }
        }
        if (is_array($size) && isset($size['w'])) {
            $w = intval($size['w']);
            $styles[] = "width: {$w}px; max-width: none;";
            if (isset($size['h'])) {
                $h = intval($size['h']);
                $styles[] = "height: {$h}px;";
            }
        }
        
        return !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';
    }
}
