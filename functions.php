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

/* ==============================================================================
   STATIC PAGE ROUTES  —  why /privacy-policy/ was 404ing

   The templates in this theme (privacy-policy.php, service.php, about.php,
   smart-energy.php) are hand-written markup. They contain no the_content(), so there is
   nothing an editor would ever supply. But WordPress will only route a URL to a template
   if a matching POST exists in the database, so /privacy-policy/ 404'd for a reason that
   has nothing to do with the theme: nobody had created and PUBLISHED a Page with that
   slug. (WordPress auto-creates a "Privacy Policy" page as a DRAFT on install, and a
   draft is not publicly viewable — which is very likely what happened here.)

   Adding page-{slug}.php fixed the WRONG-TEMPLATE half of the bug. This fixes the
   NO-SUCH-URL half: these four URLs are now served by the theme directly, whether or not
   a Page row exists. Consequences worth knowing:

     · the site no longer depends on someone remembering to publish a Page in wp-admin
       for content that lives entirely in the theme files
     · a real Page still wins. The rule is registered non-'top' so WordPress resolves a
       genuine Page first, and page-{slug}.php then picks the same template — so if you
       DO create /privacy-policy/ as a Page later, nothing here fights it.
     · status is forced to 200. Without it WordPress would keep the 404 header it had
       already decided on, and the page would render correctly while telling search
       engines it does not exist.

   If you add another static template, add its slug to the list in one place below.
   ============================================================================== */
if (!function_exists('synergy_static_routes')) {
    function synergy_static_routes() {
        return array('privacy-policy', 'service', 'about', 'smart-energy');
    }
}

if (!function_exists('synergy_register_static_routes') && function_exists('add_action')) {

    function synergy_register_static_routes() {
        foreach (synergy_static_routes() as $slug) {
            add_rewrite_rule(
                '^' . $slug . '/?$',
                'index.php?synergy_static=' . $slug,
                'bottom'          // 'bottom' so a real Page/post with this slug still wins
            );
        }
    }
    add_action('init', 'synergy_register_static_routes');

    function synergy_static_query_var($vars) {
        $vars[] = 'synergy_static';
        return $vars;
    }
    add_filter('query_vars', 'synergy_static_query_var');

    function synergy_static_template($template) {
        $slug = get_query_var('synergy_static');
        if (!$slug || !in_array($slug, synergy_static_routes(), true)) {
            return $template;
        }
        $file = get_theme_file_path($slug . '.php');
        if (!file_exists($file)) {
            return $template;
        }
        // WordPress found no post, so it has already queued a 404. Undo that.
        status_header(200);
        global $wp_query;
        $wp_query->is_404 = false;
        return $file;
    }
    add_filter('template_include', 'synergy_static_template');

    /* Rewrite rules are cached in the database, so a new rule does nothing until they are
       rebuilt — normally by visiting Settings > Permalinks and pressing Save. Doing it here
       means the routes work the moment the theme files are uploaded, with no admin step.
       Guarded by a version option so this runs ONCE, not on every request: flushing
       rewrite rules on every page load is a well-known way to make a site crawl. Bump the
       version string whenever synergy_static_routes() changes. */
    function synergy_maybe_flush_rewrites() {
        $version = 'static-routes-1';
        if (get_option('synergy_rewrite_version') !== $version) {
            flush_rewrite_rules();
            update_option('synergy_rewrite_version', $version);
        }
    }
    add_action('wp_loaded', 'synergy_maybe_flush_rewrites');
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

// ============================================================
// WordPress function stubs for standalone PHP usage
// These are no-ops / pass-throughs that keep pages working
// when running outside a real WordPress installation.
// ============================================================

if (!function_exists('esc_url')) {
    function esc_url($url, $protocols = null, $_context = 'display') {
        return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('esc_html')) {
    function esc_html($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('esc_attr')) {
    function esc_attr($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('esc_js')) {
    function esc_js($text) {
        return addslashes($text);
    }
}
if (!function_exists('esc_textarea')) {
    function esc_textarea($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('wp_kses_post')) {
    function wp_kses_post($data) {
        return $data; // Allow all HTML in standalone mode
    }
}
if (!function_exists('wp_kses')) {
    function wp_kses($data, $allowed_html, $allowed_protocols = []) {
        return $data;
    }
}
if (!function_exists('antispambot')) {
    function antispambot($email_address, $hex_encoding = 0) {
        return $email_address;
    }
}
if (!function_exists('get_the_ID')) {
    function get_the_ID() { return 0; }
}
if (!function_exists('get_post_meta')) {
    function get_post_meta($post_id, $key = '', $single = false) {
        return $single ? '' : [];
    }
}
if (!function_exists('is_page')) {
    function is_page($page = '') { return false; }
}
if (!function_exists('is_singular')) {
    function is_singular($post_types = '') { return false; }
}
if (!function_exists('is_archive')) {
    function is_archive() { return false; }
}
if (!function_exists('is_search')) {
    function is_search() { return false; }
}
if (!function_exists('is_404')) {
    function is_404() { return false; }
}
if (!function_exists('get_option')) {
    function get_option($option, $default = false) { return $default; }
}
if (!function_exists('__')) {
    function __($text, $domain = 'default') { return $text; }
}
if (!function_exists('_e')) {
    function _e($text, $domain = 'default') { echo $text; }
}
if (!function_exists('_n')) {
    function _n($single, $plural, $number, $domain = 'default') {
        return ($number === 1) ? $single : $plural;
    }
}
if (!function_exists('apply_filters')) {
    function apply_filters($tag, $value) { return $value; }
}
if (!function_exists('do_action')) {
    function do_action($tag, ...$args) {}
}
if (!function_exists('get_bloginfo')) {
    function get_bloginfo($show = '', $filter = 'raw') { return ''; }
}
if (!function_exists('site_url')) {
    function site_url($path = '', $scheme = null) { return '.' . $path; }
}
if (!function_exists('admin_url')) {
    function admin_url($path = '', $scheme = 'admin') { return '.' . $path; }
}
if (!function_exists('wp_nonce_field')) {
    function wp_nonce_field($action = -1, $name = '_wpnonce', $referer = true, $echo = true) {
        $field = '<input type="hidden" name="' . esc_attr($name) . '" value="stubbed_nonce">';
        if ($echo) echo $field;
        return $field;
    }
}
if (!function_exists('checked')) {
    function checked($checked, $current = true, $echo = true) {
        $result = ($checked == $current) ? ' checked="checked"' : '';
        if ($echo) echo $result;
        return $result;
    }
}
if (!function_exists('selected')) {
    function selected($selected, $current = true, $echo = true) {
        $result = ($selected == $current) ? ' selected="selected"' : '';
        if ($echo) echo $result;
        return $result;
    }
}
if (!function_exists('wp_create_nonce')) {
    function wp_create_nonce($action = -1) { return 'stubbed_nonce'; }
}
if (!function_exists('sanitize_text_field')) {
    function sanitize_text_field($str) { return strip_tags(trim($str)); }
}
if (!function_exists('absint')) {
    function absint($maybeint) { return abs((int) $maybeint); }
}
if (!function_exists('number_format_i18n')) {
    function number_format_i18n($number, $decimals = 0) {
        return number_format($number, $decimals);
    }
}
if (!function_exists('human_time_diff')) {
    function human_time_diff($from, $to = 0) {
        if (empty($to)) $to = time();
        $diff = abs($to - $from);
        if ($diff < 60) return $diff . ' seconds';
        if ($diff < 3600) return round($diff / 60) . ' minutes';
        if ($diff < 86400) return round($diff / 3600) . ' hours';
        return round($diff / 86400) . ' days';
    }
}
