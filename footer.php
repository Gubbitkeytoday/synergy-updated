<?php
/**
 * footer.php — the pair to header.php. See the long note in that file for why both exist.
 *
 * Without this, a plugin template calling get_footer() got
 * wp-includes/theme-compat/footer.php, whose entire output is the "%s is proudly powered
 * by WordPress" line that appeared on the live /privacy-policy/ page.
 *
 * Closes the #main wrapper header.php opened, then mounts the real footer and the cookie
 * banner so a plugin-rendered page is still PDPA-compliant — the consent banner must be
 * present on every page that can be reached, not only the ones this theme hand-built.
 */

if (!defined('ABSPATH')) { exit; }
?>
</div><!-- /#main opened in header.php -->

<div id="footer-container" class="bg-ink w-full block"></div>

<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : get_theme_file_uri('components/scripts.js'); ?>"></script>
<?php include get_theme_file_path('components/cookie-consent.php'); ?>
<?php wp_footer(); ?>
</body>
</html>
