<?php
/**
 * Generic Page template — the missing rung in the ladder.
 *
 * WHY THIS FILE IS THE ONE THAT STOPS THE BUG COMING BACK
 *
 * WordPress resolves a Page like this:
 *   page-{slug}.php  ->  page-{id}.php  ->  page.php  ->  singular.php  ->  index.php
 *
 * The theme had ONLY the first rung, and only for some slugs (about, smart-energy). Every
 * other Page — /privacy-policy/, /service/, and every Page anyone adds in the admin from
 * now on — dropped straight to index.php, which is a hard-coded home page. So a brand new
 * Page in WordPress showed the home page and looked like a redirect bug.
 *
 * Adding page-{slug}.php for each page fixes them one at a time and only after someone
 * notices. This file fixes the class: any Page with no dedicated template now renders its
 * own title and content instead of the home page, so the next page added cannot reproduce
 * the bug at all.
 *
 * This is the only template in the theme that runs a real WordPress loop — the others are
 * static markup — so the content comes from the editor and the type scale below is what
 * styles it.
 */

$sy_title = function_exists('wp_get_document_title') ? wp_get_document_title() : get_the_title();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php include __DIR__ . '/components/doc-head.php'; ?>
</head>
<body <?php body_class('bg-white text-body antialiased'); ?>>

<a class="skip-link fixed top-3 left-3 z-[99999] bg-brand text-white px-5 py-2.5 rounded-full font-bold text-sm -translate-y-24 focus:translate-y-0 transition duration-200" href="#main">ข้ามไปยังเนื้อหาหลัก</a>

<div id="navbar-container"></div>

<!-- pt-20 clears the fixed 80px navbar that components/scripts.js injects — see 404.php. -->
<main id="main" class="bg-white pt-20">
  <?php while (have_posts()) : the_post(); ?>

    <header class="bg-surface border-b border-slate-100">
      <div class="max-w-4xl mx-auto px-6 py-14 lg:py-20">
        <h1 class="font-display sy-h2 text-brand"><?php the_title(); ?></h1>
        <div class="w-16 h-[3px] bg-brand rounded-full mt-4"></div>
      </div>
    </header>

    <article class="max-w-4xl mx-auto px-6 py-12 lg:py-16 sy-prose">
      <?php the_content(); ?>
    </article>

  <?php endwhile; ?>
</main>

<div id="footer-container" class="bg-ink w-full block"></div>

<style>
  /* Editor content arrives as bare h2/h3/p/ul, so it is styled by element here. Sizes are
     rem with !important for the reason given in AGENTS.md §2, and the Thai leading and
     word-break rules from §3 apply to every paragraph the editor produces. */
  .sy-prose { font-size: 1.075rem; line-height: 1.8; color: #3A4A41; word-break: normal; text-wrap: pretty; }
  .sy-prose > * + * { margin-top: 1.1em; }
  .sy-prose h2 { font-family: 'Space Grotesk', 'SukhumvitSet', sans-serif; font-size: 1.6rem !important; line-height: 1.3 !important; font-weight: 800; color: #0B1F16; margin-top: 2em; }
  .sy-prose h3 { font-size: 1.25rem !important; line-height: 1.35 !important; font-weight: 700; color: #0B1F16; margin-top: 1.6em; }
  .sy-prose p, .sy-prose li { font-size: 1.075rem !important; line-height: 1.8 !important; }
  html[lang="en"] .sy-prose p, html[lang="en"] .sy-prose li { line-height: 1.65 !important; }
  .sy-prose ul, .sy-prose ol { padding-left: 1.4em; }
  .sy-prose ul { list-style: disc; }
  .sy-prose ol { list-style: decimal; }
  .sy-prose li + li { margin-top: .45em; }
  /* #5C6E65 is the darkest tone that still reads as secondary and clears WCAG AA 4.5:1
     on white — slate-400 is 2.6:1 and fails. AGENTS.md §3. */
  .sy-prose blockquote { border-left: 3px solid #d2ebd9; padding-left: 1.1em; color: #5C6E65; }
  .sy-prose a { color: #1F6B43; font-weight: 700; text-decoration: underline; text-underline-offset: 2px; }
  .sy-prose img { max-width: 100%; height: auto; border-radius: 14px; }
  .sy-prose table { width: 100%; border-collapse: collapse; }
  .sy-prose :is(td, th) { border: 1px solid #e3e9e5; padding: 10px 12px; text-align: left; }
  /* Wide content must scroll inside itself rather than making the page scroll sideways. */
  .sy-prose :is(table, pre) { display: block; overflow-x: auto; }
</style>

<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
<?php include __DIR__ . '/components/cookie-consent.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
