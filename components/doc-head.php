<?php
/**
 * Shared document head for the theme's generic templates (page.php, 404.php).
 *
 * WHY IT EXISTS
 * The hand-built page templates (index, about, service, smart-energy, privacy-policy)
 * each carry their own <head> because each has its own SEO copy, OG image and per-page
 * type scale. The generic templates have none of that to say, so duplicating ~40 lines
 * of CDN links into each of them would only create three places to forget to update.
 *
 * USAGE — set the variables, then include:
 *     $sy_title  = 'Page title';
 *     $sy_robots = 'noindex, follow';   // optional, defaults to index, follow
 *     $sy_desc   = 'meta description';  // optional
 *     include __DIR__ . '/components/doc-head.php';
 *
 * Deliberately NOT a function: it has to emit <head> in place and the rest of the theme
 * is written in this same plain-include style.
 */

$sy_title  = isset($sy_title)  ? $sy_title  : 'Synergy Technology';
$sy_robots = isset($sy_robots) ? $sy_robots : 'index, follow';
$sy_desc   = isset($sy_desc)   ? $sy_desc   : '';
$sy_uri    = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?php echo esc_html($sy_title); ?></title>
<?php if ($sy_desc !== '') : ?>
<meta name="description" content="<?php echo esc_attr($sy_desc); ?>">
<?php endif; ?>
<meta name="theme-color" content="#1F6B43">
<meta name="color-scheme" content="light">
<meta name="robots" content="<?php echo esc_attr($sy_robots); ?>">

<link rel="icon" type="image/png" href="<?php echo $sy_uri; ?>/image/s-logo.png">
<link rel="shortcut icon" type="image/png" href="<?php echo $sy_uri; ?>/image/s-logo.png">
<link rel="apple-touch-icon" href="<?php echo $sy_uri; ?>/image/s-logo.png">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: "#0B1F16", body: "#3A4A41", muted: "#6E8076",
          brand: { DEFAULT: "#1F6B43", deep: "#0E3B2E", soft: "#E9F2EC", bright: "#23862D" },
          gold: { DEFAULT: "#C99700", bright: "#F2C72E" },
          surface: "#F6FAF7"
        },
        fontFamily: { display: ['"Space Grotesk"', 'sans-serif'] }
      }
    }
  }
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo function_exists('synergy_asset') ? synergy_asset('components/style.css') : './components/style.css'; ?>">

<style>
  body { font-family: 'SukhumvitSet', 'Inter', 'Sarabun', sans-serif; }
  /* Sizes set here, not with Tailwind text-* utilities: components/style.css pins every
     step with !important and its selectors also match the responsive variants, so a
     utility class cannot be trusted for type on this site. See AGENTS.md §2. */
  .sy-h1 { font-size: clamp(30px, 5.6vw, 60px) !important; line-height: 1.12 !important; font-weight: 800 !important; letter-spacing: -0.02em; }
  .sy-h2 { font-size: clamp(22px, 2.78vw, 40px) !important; line-height: 1.2 !important; font-weight: 800 !important; }
  /* Thai supporting copy: 1.8 leading for tone marks and stacked vowels, word-break
     normal so a space-less Thai sentence is not chopped mid-syllable. AGENTS.md §3. */
  .sy-copy { font-size: 1.075rem !important; line-height: 1.8 !important; font-weight: 400 !important; word-break: normal !important; text-wrap: pretty; }
  html[lang="en"] .sy-copy { line-height: 1.65 !important; }
</style>

<script>
  window.wpThemeUrl = "<?php echo $sy_uri; ?>/";
  window.wpThemeUri = "<?php echo $sy_uri; ?>/";
</script>
<?php wp_head(); ?>
