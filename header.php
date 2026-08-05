<?php
/**
 * header.php — for templates this theme does not own.
 *
 * WHY IT EXISTS
 * Every template in this theme prints its own <head> and closes its own </html>, so
 * nothing here calls get_header(). That is exactly why this file was missing — and why
 * /privacy-policy/ came out as a blank page reading "is proudly powered by WordPress".
 *
 * PLUGINS call get_header(). Elementor's page template does. So do WooCommerce, contact
 * form pages, and most builders. When the theme has no header.php, WordPress silently
 * falls back to wp-includes/theme-compat/header.php, which emits an XFN profile link, a
 * pingback link, a bare style.css and an EMPTY <title> — and pairs it with
 * theme-compat/footer.php's "is proudly powered by WordPress". No navbar, no Tailwind, no
 * fonts, no branding. That was the live symptom, and WordPress also logs a deprecation
 * notice for it.
 *
 * So this file is the structural fix: any plugin-rendered page now gets the real site
 * shell — head assets, navbar, cookie banner — instead of core's 2010-era placeholder.
 *
 * It is deliberately NOT used by the theme's own templates. Converting those to
 * get_header()/get_footer() would be a large refactor with nothing to gain: each one
 * needs its own per-page SEO tags, OG image and type scale in the head.
 */

if (!defined('ABSPATH')) { exit; }

$sy_title  = function_exists('wp_get_document_title') ? wp_get_document_title() : get_bloginfo('name');
$sy_robots = is_404() || is_search() ? 'noindex, follow' : 'index, follow';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php include get_theme_file_path('components/doc-head.php'); ?>
</head>
<body <?php body_class('bg-white text-body antialiased'); ?>>

<a class="skip-link fixed top-3 left-3 z-[99999] bg-brand text-white px-5 py-2.5 rounded-full font-bold text-sm -translate-y-24 focus:translate-y-0 transition duration-200" href="#main">ข้ามไปยังเนื้อหาหลัก</a>

<div id="navbar-container"></div>

<!-- pt-20 clears the fixed 80px navbar that components/scripts.js injects. -->
<div id="main" class="pt-20">
