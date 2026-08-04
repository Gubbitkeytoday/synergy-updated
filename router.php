<?php
// Router script for PHP built-in dev server
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the file exists directly (e.g. images, css, js), serve it directly
if ($path !== '/' && file_exists(__DIR__ . $path) && !is_dir(__DIR__ . $path)) {
    return false;
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
