<?php

if (php_sapi_name() !== 'cli-server') {
    die('Detta script är bara för PHPs inbyggda server.');
}

$publicPath = __DIR__ . '/public';
$requestUri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$filePath = $publicPath . $requestUri;

if ($requestUri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false;
}

require_once $publicPath . '/index.php';