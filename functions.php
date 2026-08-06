<?php
// Synergy Group Theme Functions
if (!function_exists('synergy_theme_setup')) {
    function synergy_theme_setup() {
        if (function_exists('add_theme_support')) {
            /* NO add_theme_support('title-tag') — deliberate, and it was removed for a
               reason that showed up in the served HTML.
               'title-tag' makes wp_head() emit its own <title>. But every template in this
               theme hardcodes a hand-written <title> with page-specific Thai + English SEO
               copy, and each also calls wp_head(). The live page came back with TWO empty
               <title></title> tags for that reason. Duplicate titles are an SEO defect and
               which one a crawler honours is not something to leave to chance.
               header.php / page.php / 404.php do not need this support either: they pass
               wp_get_document_title() into components/doc-head.php, which prints the tag
               itself. That function works whether or not title-tag is declared. */
            add_theme_support('post-thumbnails');
        }
    }
    if (function_exists('add_action')) {
        add_action('after_setup_theme', 'synergy_theme_setup');
    }
}

/* ==============================================================================
   STATIC PAGE ROUTES  —  serving /privacy-policy/ etc. without a Page in the database

   THE PROBLEM
   privacy-policy.php, service.php, about.php and smart-energy.php are hand-written
   markup. They contain no the_content(), so there is nothing an editor would ever supply.
   But WordPress only routes a URL to a template when a matching POST exists in the
   database, so /privacy-policy/ 404s unless somebody has created AND PUBLISHED a Page
   with that slug. (WordPress auto-creates a "Privacy Policy" page as a DRAFT on install,
   and a draft is not publicly viewable — the likely history here.)

   page-{slug}.php fixed the wrong-template half of the bug. This fixes the no-such-URL
   half.

   WHY THERE IS NO add_rewrite_rule() HERE  —  read this before "improving" it
   The first version of this code did use add_rewrite_rule() registered at 'bottom',
   reasoning that a genuine Page should still win. That reasoning is wrong and the routes
   never fired even once. WordPress ships a CATCH-ALL page rule in its default set:

       (.?.+?)(?:/([0-9]+))?/?$   ->   index.php?pagename=$matches[1]&page=$matches[2]

   It matches "privacy-policy" whether or not such a Page exists. Registered at 'bottom',
   our rule sat AFTER it, so WordPress matched the pagename rule first, set
   pagename=privacy-policy, found no post, and 404'd — our rule was never evaluated and
   the synergy_static query var was never set. Moving to 'top' would fire, but then it
   would shadow a real Page and require a rewrite-rule flush to take effect at all, which
   is one more thing to get wrong on deploy.

   Hooking template_include on an actual 404 avoids all of it:
     · nothing to flush, so it works the moment the files are uploaded
     · immune to rewrite-rule ordering
     · a real published Page wins for free — if one exists WordPress never 404s, so this
       filter returns early and page-{slug}.php handles it as normal
     · status is forced back to 200, otherwise the page would render correctly while
       telling search engines it does not exist

   To add another static template: add its slug below. Nothing else to do.
   ============================================================================== */
if (!function_exists('synergy_static_routes')) {
    function synergy_static_routes() {
        return array('privacy-policy', 'service', 'about', 'smart-energy');
    }
}

if (!function_exists('synergy_static_template') && function_exists('add_filter')) {

    /**
     * Path of the current request, relative to the WordPress home URL.
     * The home-path strip is what makes this work on a subdirectory install
     * (example.com/site/privacy-policy/ -> "privacy-policy").
     */
    function synergy_request_slug() {
        $uri  = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $path = (string) parse_url($uri, PHP_URL_PATH);
        $path = trim(rawurldecode($path), '/');

        $home = (string) parse_url(home_url('/'), PHP_URL_PATH);
        $home = trim($home, '/');
        if ($home !== '' && strpos($path, $home) === 0) {
            $path = trim(substr($path, strlen($home)), '/');
        }
        return $path;
    }

    /**
     * WHY THIS IS NOT GATED ON is_404()  —  the actual cause of the live bug
     *
     * The previous version only stepped in when WordPress had failed to resolve the URL.
     * On the live site it never fired even once, because /privacy-policy/ was NOT a 404:
     * a Page with that slug does exist. The page was broken for a completely different
     * reason, visible in the served HTML:
     *
     *     <link rel="profile" href="https://gmpg.org/xfn/11">
     *     <link rel="stylesheet" href=".../synergy-updated/style.css" media="screen">
     *     <link rel="pingback" href=".../xmlrpc.php">
     *     ... "is proudly powered by WordPress"
     *
     * That is wp-includes/theme-compat/header.php and footer.php — WordPress core's
     * fallbacks, used when a template calls get_header()/get_footer() and the theme has
     * neither. No template in THIS theme calls them. Elementor's page template does, and
     * the body class on the live page was "elementor-default elementor-kit-295".
     *
     * So: the Page had its template set to an Elementor one, stored in the
     * _wp_page_template post meta. get_page_template() places that meta value FIRST in
     * the hierarchy — ahead of page-{slug}.php — so page-privacy-policy.php was skipped
     * entirely, Elementor rendered an empty layout, and the theme-compat fallbacks
     * supplied that header and footer.
     *
     * Hence: match on the slug and take over whatever WordPress or a page builder chose.
     *
     * TRADE-OFF, STATED PLAINLY: for these four slugs the theme file now always wins, so
     * these four pages CANNOT be edited in Elementor or the block editor any more. That is
     * intended — privacy-policy.php, service.php, about.php and smart-energy.php are
     * hand-written markup with no the_content(), so an editor was never able to change
     * what they display anyway. It only looked editable. To make one of them editable,
     * remove its slug from synergy_static_routes() and build the page properly in the
     * editor instead.
     */
    function synergy_static_template($template) {
        $slug = synergy_request_slug();
        if ($slug === '' || !in_array($slug, synergy_static_routes(), true)) {
            return $template;   // not ours — leave WordPress (and 404.php) alone
        }
        $file = get_theme_file_path($slug . '.php');
        if (!file_exists($file)) {
            return $template;
        }

        // If no Page row exists WordPress has already queued a 404. Undo that, or the
        // page would render correctly while telling search engines it does not exist.
        if (is_404()) {
            status_header(200);
            header_remove('Expires');
            header_remove('Cache-Control');
            global $wp_query;
            if ($wp_query) {
                $wp_query->is_404 = false;
            }
        }
        return $file;
    }
    /* PRIORITY 9999 IS LOAD-BEARING — do not drop it back to the default.
     *
     * Registered at the default priority 10, this filter ran and returned the right
     * template, and Elementor then threw it away. Elementor's page-template module hooks
     * the same filter at priority 11:
     *
     *     add_filter( 'template_include', [ $this, 'template_include' ], 11 )
     *
     * Later priority wins the final say, so Elementor's choice replaced ours. Measured on
     * the live site after the theme-compat fix: the page rendered this theme's header.php
     * and footer.php with <div id="main"> completely EMPTY between them — that is
     * Elementor's elementor_header_footer template calling get_header(), the_content()
     * (nothing, because the Page has no Elementor content) and get_footer().
     *
     * So the shell looked correct and the page was still blank. 9999 puts this last.
     */
    add_filter('template_include', 'synergy_static_template', 9999);

    /* ---------------------------------------------------------------------------
       STOP WORDPRESS REDIRECTING THE URL AWAY BEFORE WE GET IT

       template_include runs from template-loader.php, but redirect_canonical() runs
       EARLIER, on template_redirect. On a 404 it calls redirect_guess_404_permalink(),
       which looks for a published post whose slug merely STARTS WITH the requested one
       and 301s to it — and if it finds nothing usable the request can still end up
       bounced to the site root. That is the original reported symptom exactly: open
       /privacy-policy/ and land on the home page.

       So a redirect can beat us to it, and no amount of correctness in the template
       filter would help — the response is already a 3xx by then. These two filters opt
       our static slugs out of both guessing paths. They are scoped to those slugs only,
       so canonical redirects keep working normally everywhere else on the site (trailing
       slashes, ?p=123, uppercase paths and so on).
       --------------------------------------------------------------------------- */
    function synergy_is_static_request() {
        return in_array(synergy_request_slug(), synergy_static_routes(), true);
    }

    function synergy_block_404_guess($do_guess) {
        return synergy_is_static_request() ? false : $do_guess;
    }
    add_filter('do_redirect_guess_404_permalink', 'synergy_block_404_guess');

    function synergy_block_canonical_redirect($redirect_url) {
        return synergy_is_static_request() ? false : $redirect_url;
    }
    add_filter('redirect_canonical', 'synergy_block_canonical_redirect');
}

// Cache-busting URL for theme assets: /components/style.css -> .../components/style.css?v=1712345678
if (!function_exists('synergy_asset')) {
    function synergy_asset($relative_path) {
        $relative_path = '/' . ltrim($relative_path, '/');
        $base_dir = function_exists('get_template_directory') ? get_template_directory() : __DIR__;
        // '' not '.', so the URL stays root-absolute and resolves the same from
        // /about/ as from /. See synergy_dev_base() in about.php.
        $base_url = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '';
        $file = $base_dir . $relative_path;
        $url  = $base_url . $relative_path;
        return file_exists($file) ? $url . '?v=' . filemtime($file) : $url;
    }
}

if (!function_exists('synergy_theme_scripts')) {
    function synergy_theme_scripts() {
        $base_dir = function_exists('get_stylesheet_directory') ? get_stylesheet_directory() : __DIR__;
        $style_uri = function_exists('get_stylesheet_uri') ? get_stylesheet_uri() : '/style.css';
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
