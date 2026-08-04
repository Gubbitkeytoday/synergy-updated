<?php
/**
 * Template for the /about/ page.
 *
 * Why this file exists:
 * WordPress resolves a Page through the template hierarchy
 *   page-{slug}.php  ->  page-{id}.php  ->  page.php  ->  singular.php  ->  index.php
 * This theme had none of the first four, so /about/ fell all the way through to
 * index.php - and index.php renders the full home page. That is why the URL read
 * /about/ while the content was the home page.
 *
 * page-about.php is picked automatically for any Page whose slug is "about", with no
 * template to select in the admin. The markup itself stays in about.php, which also
 * remains selectable as the "About Us" page template.
 */

require get_theme_file_path( 'about.php' );
