<?php
// Router script for PHP built-in dev server
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the file exists directly (e.g. images, css, js), serve it directly
if ($path !== '/' && file_exists(__DIR__ . $path) && !is_dir(__DIR__ . $path)) {
    return false;
}

/* A request for a file that does not exist must 404, not fall through to a page
   template. Without this, a mis-resolved asset URL such as
   /about/components/style.css answered with the About page HTML at status 200:
   the stylesheet parsed to zero rules and the scripts never ran, which looks
   like a CSS/JS bug rather than a 404. Anything with a file extension that is
   not .php/.html is an asset request. */
if (preg_match('/\.([a-z0-9]{2,5})$/i', $path, $m)
    && !in_array(strtolower($m[1]), ['php', 'html'], true)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo "404 Not Found: " . $path . "\n";
    exit;
}

// Clean trailing slash
$cleanPath = rtrim($path, '/');

// Handle /about or /about/
if ($cleanPath === '/about') {
    require __DIR__ . '/about.php';
    exit;
}

// Handle /service or /service/ or /services
if ($cleanPath === '/service' || $cleanPath === '/services') {
    require __DIR__ . '/service.php';
    exit;
}

// Handle /privacy-policy (and /cookie-policy, which is a section of the same document)
if ($cleanPath === '/privacy-policy' || $cleanPath === '/privacy') {
    require __DIR__ . '/privacy-policy.php';
    exit;
}
if ($cleanPath === '/cookie-policy' || $cleanPath === '/cookies') {
    header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/privacy-policy#cookies', true, 302);
    exit;
}

// Handle /index or /
if ($cleanPath === '' || $cleanPath === '/index') {
    require __DIR__ . '/index.php';
    exit;
}

// Handle filename + .php
if (file_exists(__DIR__ . $cleanPath . '.php')) {
    require __DIR__ . $cleanPath . '.php';
    exit;
}

// Handle filename + .html
if (file_exists(__DIR__ . $cleanPath . '.html')) {
    require __DIR__ . $cleanPath . '.html';
    exit;
}

return false;
