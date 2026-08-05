<?php
/**
 * 404 template.
 *
 * WHY THIS FILE IS THE REAL FIX, NOT JUST page-privacy-policy.php
 *
 * The theme had no 404.php, so WordPress fell back to index.php for every request it
 * could not resolve — and index.php is a hard-coded home page (it contains no
 * have_posts() or the_content() at all). The result: EVERY broken or mistyped URL on the
 * site quietly served the home page with a 200 OK.
 *
 * Two consequences, and the second is the expensive one:
 *
 *  1. It hides the actual problem. /privacy-policy/ showing the home page looked like a
 *     redirect bug. It was not — there was no redirect anywhere. The page simply was not
 *     resolvable and the fallback template was the home page. With this file in place the
 *     same situation says "not found" and points at the real cause.
 *
 *  2. It is a SOFT 404, which search engines treat as a defect. Google saw the home page
 *     content served from an unlimited number of URLs, all returning 200 — that is
 *     duplicate content at scale, and it never learns any URL is dead, so broken links
 *     stay in the index indefinitely. A real 404 status is what removes them.
 *
 * status_header(404) is set explicitly rather than trusted: WordPress does set it for a
 * genuine 404 query, but if this template is ever reached another way (a plugin, a
 * manual include) the status must still be correct — the status code is the entire point.
 */

if (!headers_sent()) {
    if (function_exists('status_header')) { status_header(404); }
    if (function_exists('nocache_headers')) { nocache_headers(); }
}

$sy_title  = 'ไม่พบหน้าที่ต้องการ (404) | Page not found — Synergy Technology';
$sy_robots = 'noindex, follow';   // never index an error page; still follow its links out
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php include __DIR__ . '/components/doc-head.php'; ?>
</head>
<body <?php body_class('bg-white text-body antialiased'); ?>>

<a class="skip-link fixed top-3 left-3 z-[99999] bg-brand text-white px-5 py-2.5 rounded-full font-bold text-sm -translate-y-24 focus:translate-y-0 transition duration-200" href="#main">ข้ามไปยังเนื้อหาหลัก</a>

<div id="navbar-container"></div>

<!-- pt-20 clears the navbar. components/scripts.js renders it as position:fixed with an
     h-20 (80px) bar, so without top padding the first thing on the page sits underneath
     it. Every other template accounts for this — service.php via
     min-height:calc(100vh - 80px), scripts.js via navbarOffset = 96. -->
<main id="main" class="min-h-[70vh] flex items-center bg-surface pt-20">
  <div class="max-w-3xl mx-auto px-6 py-20 text-center">

    <!-- A <div>, not a <p>, and the size carries !important — BOTH on purpose.
         components/style.css sets `p { font-size: 1.075rem !important }` (a bare element
         selector, so it catches every paragraph on the site). An inline style without
         !important LOSES to a stylesheet rule that has it, so this numeral rendered at
         ~19px instead of the 72-168px it asks for. This is exactly the trap written up in
         AGENTS.md §2, walked into while writing this very file. -->
    <div class="font-display text-brand/40 font-extrabold" style="font-size:clamp(72px,16vw,168px) !important;line-height:1 !important">404</div>

    <h1 class="font-display sy-h1 text-ink mt-2">
      <span class="lang-th">ไม่พบหน้าที่ท่านต้องการ</span>
      <span class="lang-en">We couldn’t find that page</span>
    </h1>

    <p class="sy-copy text-body mt-5 max-w-xl mx-auto">
      <span class="lang-th">หน้านี้อาจถูกย้าย เปลี่ยนชื่อ หรือลบไปแล้ว หรือลิงก์ที่ท่านตามมาอาจไม่ถูกต้อง</span>
      <span class="lang-en">The page may have been moved, renamed or removed — or the link you followed may be incorrect.</span>
    </p>

    <div class="flex flex-wrap justify-center gap-3 mt-9">
      <a href="<?php echo home_url('/'); ?>"
         class="bg-brand hover:bg-brand-deep text-white font-extrabold px-7 py-3.5 rounded-xl shadow-lg transition duration-200 inline-flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
        <span class="lang-th">กลับหน้าแรก</span><span class="lang-en">Back to home</span>
      </a>
      <a href="<?php echo home_url('/'); ?>#contact"
         class="bg-white hover:bg-brand-soft text-brand border border-brand font-extrabold px-7 py-3.5 rounded-xl transition duration-200 inline-flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        <span class="lang-th">ติดต่อเรา</span><span class="lang-en">Contact us</span>
      </a>
    </div>

    <?php
    /* NO SEARCH FORM HERE ON PURPOSE.
       The obvious thing to put on a 404 is a search box, but this theme has no search.php
       either — so /?s=... would fall through the same hierarchy to index.php and serve the
       home page, which is the exact bug this file exists to stop. Offering it would send
       the visitor from one dead end into another. Add search.php first, then add the form. */
    ?>

    <nav class="mt-14 pt-8 border-t border-slate-200/70" aria-label="ลิงก์หน้าหลัก">
      <p class="sy-copy text-muted mb-3" style="font-size:0.975rem !important;color:#5C6E65">
        <span class="lang-th">หรือไปที่หน้าอื่น</span><span class="lang-en">Or try one of these</span>
      </p>
      <ul class="flex flex-wrap justify-center gap-x-6 gap-y-2">
        <li><a class="text-brand font-bold underline" style="text-underline-offset:3px" href="<?php echo home_url('/service/'); ?>"><span class="lang-th">บริการ</span><span class="lang-en">Services</span></a></li>
        <li><a class="text-brand font-bold underline" style="text-underline-offset:3px" href="<?php echo home_url('/about/'); ?>"><span class="lang-th">เกี่ยวกับเรา</span><span class="lang-en">About us</span></a></li>
        <li><a class="text-brand font-bold underline" style="text-underline-offset:3px" href="<?php echo home_url('/smart-energy/'); ?>">Smart Energy</a></li>
        <li><a class="text-brand font-bold underline" style="text-underline-offset:3px" href="<?php echo home_url('/privacy-policy/'); ?>"><span class="lang-th">นโยบายความเป็นส่วนตัว</span><span class="lang-en">Privacy Policy</span></a></li>
      </ul>
    </nav>

  </div>
</main>

<div id="footer-container" class="bg-ink w-full block"></div>

<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
<?php include __DIR__ . '/components/cookie-consent.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
