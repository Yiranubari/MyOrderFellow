<?php
// Get the requested URI path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check if the request is for a static file in public directory
$staticFile = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($staticFile) && is_file($staticFile)) {
    // Serve static files with correct mime type
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
    ];
    $ext = pathinfo($staticFile, PATHINFO_EXTENSION);
    $mime = $mimeTypes[$ext] ?? 'application/octet-stream';
    header('Content-Type: ' . $mime);
    readfile($staticFile);
    return;
}

// Route everything else through the main entry point
require_once __DIR__ . '/public/index.php';
