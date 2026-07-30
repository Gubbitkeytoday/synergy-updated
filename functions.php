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
