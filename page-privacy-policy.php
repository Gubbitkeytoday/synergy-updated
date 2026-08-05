<?php
/**
 * Template for the /privacy-policy/ page.
 *
 * Why this file exists — the same bug that page-about.php already documents:
 * WordPress resolves a Page through the template hierarchy
 *   page-{slug}.php  ->  page-{id}.php  ->  page.php  ->  singular.php  ->  index.php
 * This theme had none of the first four for this slug, so /privacy-policy/ fell all the
 * way through to index.php - and index.php renders the full home page. That is why the
 * URL read /privacy-policy/ while the content was the home page. It was never a
 * redirect: nothing ever sent a Location header, the browser stayed on the URL you
 * asked for and WordPress simply handed it the wrong template.
 *
 * page-privacy-policy.php is picked automatically for any Page whose slug is
 * "privacy-policy", with no template to select in the admin. The markup itself stays in
 * privacy-policy.php, which also remains selectable as the "Privacy Policy" template.
 *
 * NOTE: this only helps if a PUBLISHED Page with the slug privacy-policy exists. See
 * 404.php for what happens when it does not.
 */

require get_theme_file_path( 'privacy-policy.php' );
