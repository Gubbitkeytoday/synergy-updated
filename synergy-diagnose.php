<?php
/**
 * ไฟล์ตรวจอาการ — ใช้ครั้งเดียวแล้วลบทิ้ง / One-shot diagnostic. DELETE AFTER USE.
 *
 * ทำไมต้องมีไฟล์นี้
 * ผมแก้ /privacy-policy/ ไปสองรอบแล้วยังไม่ได้ เพราะผมมองไม่เห็นเซิร์ฟเวอร์ของคุณ —
 * เดาต่อไปก็เสียเวลาเปล่า ไฟล์นี้ทำให้ WordPress ตอบเองว่าตอนนี้อะไรเป็นอะไร
 *
 * WHY THIS EXISTS
 * Two attempts at /privacy-policy/ have not landed, and I cannot see the server. Rather
 * than guess a third time, this makes WordPress state the facts.
 *
 * วิธีใช้ / HOW TO USE
 *   1. อัปโหลดไฟล์นี้ไว้ในโฟลเดอร์ธีม (ที่เดียวกับ functions.php)
 *   2. เปิด  https://โดเมนของคุณ/wp-content/themes/ชื่อธีม/synergy-diagnose.php
 *   3. ก๊อปผลทั้งหมดส่งกลับมา
 *   4. ลบไฟล์นี้ออกจากเซิร์ฟเวอร์
 *
 * ความปลอดภัย: ต้องล็อกอินเป็นแอดมินก่อนถึงจะเห็นผล คนอื่นเปิดจะไม่ได้อะไรเลย
 * ไม่แสดงรหัสผ่าน คีย์ หรือค่าคอนฟิกของฐานข้อมูล และไม่แก้ไขอะไรทั้งสิ้น — อ่านอย่างเดียว
 * SECURITY: admin login required; nothing else is exposed. No secrets, no writes.
 */

// โหลด WordPress ขึ้นมา (ไต่ขึ้นไปหา wp-load.php จากตำแหน่งไฟล์นี้)
$dir = __DIR__;
$loaded = false;
for ($i = 0; $i < 8; $i++) {
    if (file_exists($dir . '/wp-load.php')) {
        require_once $dir . '/wp-load.php';
        $loaded = true;
        break;
    }
    $parent = dirname($dir);
    if ($parent === $dir) { break; }
    $dir = $parent;
}
if (!$loaded) {
    exit('หา wp-load.php ไม่เจอ — ไฟล์นี้ต้องอยู่ในโฟลเดอร์ธีมของ WordPress');
}

if (!current_user_can('manage_options')) {
    status_header(403);
    exit('ต้องล็อกอินเป็นผู้ดูแลระบบก่อน แล้วเปิดหน้านี้อีกครั้ง / Admin login required.');
}

header('Content-Type: text/plain; charset=utf-8');

function d_line($k, $v) { printf("%-38s %s\n", $k, $v); }
function d_head($t) { echo "\n" . str_repeat('=', 72) . "\n" . $t . "\n" . str_repeat('=', 72) . "\n"; }
function d_yn($b) { return $b ? 'YES' : 'no'; }

echo "SYNERGY DIAGNOSTIC — " . date('Y-m-d H:i:s') . "\n";

d_head('1. WORDPRESS / THEME');
d_line('WordPress version', get_bloginfo('version'));
d_line('PHP version', PHP_VERSION);
d_line('home_url()', home_url('/'));
d_line('site_url()', site_url('/'));
d_line('Active theme', wp_get_theme()->get('Name'));
d_line('Theme directory', get_template_directory());
d_line('Is child theme', d_yn(get_template_directory() !== get_stylesheet_directory()));

d_head('2. PERMALINKS  (ถ้าเป็น Plain / ว่าง = ต้นเหตุ)');
$structure = get_option('permalink_structure');
d_line('permalink_structure', $structure === '' ? '(EMPTY = "Plain" — THIS BREAKS /privacy-policy/)' : $structure);
if (function_exists('got_mod_rewrite')) {
    d_line('Apache mod_rewrite', d_yn(got_mod_rewrite()));
}
$htaccess = ABSPATH . '.htaccess';
d_line('.htaccess exists', d_yn(file_exists($htaccess)));
if (file_exists($htaccess)) {
    d_line('.htaccess writable', d_yn(is_writable($htaccess)));
    d_line('.htaccess has WP block', d_yn(strpos((string) file_get_contents($htaccess), 'BEGIN WordPress') !== false));
}
d_line('Server software', isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '?');

d_head('3. THEME TEMPLATE FILES  (ต้องมีครบ)');
foreach (array(
    '404.php', 'page.php', 'index.php', 'front-page.php', 'functions.php',
    'privacy-policy.php', 'page-privacy-policy.php',
    'service.php', 'page-service.php',
    'about.php', 'page-about.php',
    'smart-energy.php', 'page-smart-energy.php',
    'components/doc-head.php', 'components/scripts.js', 'components/style.css',
    'components/cookie-consent.php',
) as $f) {
    $p = get_theme_file_path($f);
    d_line($f, file_exists($p) ? 'ok (' . number_format(filesize($p)) . ' bytes)' : '*** MISSING ***');
}

d_head('4. MY ROUTING CODE — LOADED?');
d_line('synergy_static_routes() exists', d_yn(function_exists('synergy_static_routes')));
d_line('synergy_static_template() exists', d_yn(function_exists('synergy_static_template')));
d_line('synergy_request_slug() exists', d_yn(function_exists('synergy_request_slug')));
if (function_exists('synergy_static_routes')) {
    d_line('routes registered', implode(', ', synergy_static_routes()));
}
d_line('template_include filter attached', d_yn(has_filter('template_include', 'synergy_static_template') !== false));
d_line('redirect_canonical guard attached', d_yn(has_filter('redirect_canonical', 'synergy_block_canonical_redirect') !== false));
d_line('OLD rewrite fn still present', d_yn(function_exists('synergy_register_static_routes')) . ' (should be "no" — remove old functions.php if YES)');

d_head('5. PAGES IN THE DATABASE');
foreach (array('privacy-policy', 'service', 'about', 'smart-energy') as $slug) {
    $page = get_page_by_path($slug, OBJECT, 'page');
    if ($page) {
        d_line('/' . $slug . '/', 'Page ID ' . $page->ID . '  status=' . $page->post_status
            . '  template=' . (get_page_template_slug($page->ID) ?: '(default)'));
    } else {
        // ดูว่ามีอยู่แต่เป็นร่าง / ถังขยะ หรือเปล่า — get_page_by_path เห็นแต่ที่ published
        $any = get_posts(array(
            'name' => $slug, 'post_type' => 'page', 'numberposts' => 1,
            'post_status' => array('draft', 'pending', 'private', 'trash', 'future', 'auto-draft'),
        ));
        if ($any) {
            d_line('/' . $slug . '/', '*** EXISTS BUT status=' . $any[0]->post_status
                . ' (ID ' . $any[0]->ID . ') — not publicly viewable ***');
        } else {
            d_line('/' . $slug . '/', 'no Page in DB (will be served by the theme route)');
        }
    }
}
$wp_privacy = (int) get_option('wp_page_for_privacy_policy');
d_line('WP privacy policy page option', $wp_privacy ? ('ID ' . $wp_privacy . ' status=' . get_post_status($wp_privacy)) : 'not set');

d_head('6. SIMULATE A REQUEST TO /privacy-policy/  (ตัวชี้ขาด)');
$target = home_url('/privacy-policy/');
d_line('Requesting', $target);
$res = wp_remote_get($target, array('timeout' => 20, 'redirection' => 0, 'sslverify' => false));
if (is_wp_error($res)) {
    d_line('RESULT', 'request failed: ' . $res->get_error_message());
} else {
    $code = wp_remote_retrieve_response_code($res);
    $loc  = wp_remote_retrieve_header($res, 'location');
    $body = (string) wp_remote_retrieve_body($res);
    d_line('HTTP status', $code);
    d_line('Location header', $loc ? $loc : '(none — no redirect)');
    d_line('Body size', number_format(strlen($body)) . ' bytes');

    // ลายนิ้วมือว่าได้หน้าอะไรมาจริง
    $is_policy = (stripos($body, 'นโยบายความเป็นส่วนตัว') !== false || stripos($body, 'Privacy Policy') !== false);
    $is_home   = (stripos($body, 'We Integrate') !== false || stripos($body, 'EXPLORE SOLUTIONS') !== false);
    $is_404pg  = (stripos($body, 'ไม่พบหน้าที่ท่านต้องการ') !== false || stripos($body, 'couldn') !== false);
    d_line('looks like the POLICY page', d_yn($is_policy));
    d_line('looks like the HOME page', d_yn($is_home) . ($is_home ? '   <-- นี่คืออาการที่คุณเจอ' : ''));
    d_line('looks like the 404 page', d_yn($is_404pg));

    echo "\nVERDICT: ";
    if ($code >= 300 && $code < 400)      echo "ถูก REDIRECT ไปที่ " . $loc . " — ดูข้อ 2 (permalinks) และปลั๊กอินในข้อ 7\n";
    elseif ($is_policy && $code == 200)   echo "ใช้งานได้แล้ว ✅ ถ้าเบราว์เซอร์ยังเห็นของเก่า ให้ล้าง cache / ปิด cache plugin\n";
    elseif ($is_home)                     echo "ได้หน้าแรก = ยังหยิบ template ผิด → functions.php ตัวใหม่ยังไม่ได้อัปโหลด หรือมีปลั๊กอินแทรก\n";
    elseif ($is_404pg)                    echo "ได้หน้า 404 = routing ยังไม่ทำงาน ดูข้อ 4 ว่าโค้ดโหลดหรือยัง\n";
    else                                  echo "ได้อะไรมาไม่รู้จัก — ส่ง 400 ตัวแรกของ body ที่พิมพ์ข้างล่างมาด้วย\n";

    if (!$is_policy) {
        echo "\n--- first 400 chars of body ---\n" . substr(preg_replace('/\s+/', ' ', $body), 0, 400) . "\n";
    }
}

d_head('7. PLUGINS ที่มักทำให้เกิดอาการนี้');
$active = (array) get_option('active_plugins', array());
d_line('active plugin count', count($active));
$suspect_words = array('redirect', 'seo', 'cache', 'security', 'coming-soon', 'maintenance', 'firewall', 'wordfence', 'litespeed', 'rocket', 'polylang', 'wpml', 'translatepress');
foreach ($active as $p) {
    $flag = '';
    foreach ($suspect_words as $w) {
        if (stripos($p, $w) !== false) { $flag = '   <-- อาจเกี่ยว (redirect / cache / multilingual)'; break; }
    }
    echo '  - ' . $p . $flag . "\n";
}

d_head('8. FRONT PAGE SETTINGS');
d_line('show_on_front', get_option('show_on_front'));
d_line('page_on_front', get_option('page_on_front'));
d_line('page_for_posts', get_option('page_for_posts'));

echo "\n\nจบแล้ว — ก๊อปทั้งหมดส่งกลับมา แล้ว **ลบไฟล์ synergy-diagnose.php ออกจากเซิร์ฟเวอร์**\n";
echo "Done — send this whole output back, then DELETE synergy-diagnose.php from the server.\n";
