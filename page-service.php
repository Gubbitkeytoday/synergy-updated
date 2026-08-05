<?php
/**
 * Template for the /service/ page.
 *
 * Same bug as page-about.php and page-privacy-policy.php: with no page-service.php,
 * page.php or singular.php in the theme, a Page with the slug "service" fell through
 * the template hierarchy to index.php and rendered the home page instead.
 *
 * This was NOT reported — it was found while fixing /privacy-policy/, because the two
 * share one cause. service.php sets its own canonical to home_url('/service/'), so the
 * URL was expected to work; it did not.
 *
 * The markup stays in service.php, which also remains selectable as the "Services Page"
 * template in the admin.
 */

require get_theme_file_path( 'service.php' );
