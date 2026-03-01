<?php

// Absolute path to the Symfony public directory
$publicDir = realpath(__DIR__ . "/public") ?: (__DIR__ . "/public");

// Serve static files directly (css, images, js)
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?? "/";
$file = $publicDir . $path;

if ($path !== "/" && is_file($file)) {
    return false;
}

// Tell Symfony Runtime that index.php is the entrypoint
$_SERVER["SCRIPT_FILENAME"] = $publicDir . "/index.php";
$_SERVER["SCRIPT_NAME"] = "/index.php";

// Hand off to Symfony front controller
require $publicDir . "/index.php";
return true;