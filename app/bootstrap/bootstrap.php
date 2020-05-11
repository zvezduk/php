<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

$path = dirname(__DIR__);

require $path . '/vendor/autoload.php';

define('IS_DEV', getenv('APP_ENV') == 'dev');
define('IS_PROD', getenv('APP_ENV') == 'prod');
define('IS_TEST', getenv('APP_ENV') == 'testing');

// Instantiate the app
$settings = require $path . '/bootstrap/settings.php';

$app = new \Slim\App($settings);

// Set up dependencies
require $path . '/bootstrap/dependencies.php';

// Register middleware
require $path . '/bootstrap/middleware.php';

// Register routes
require $path . '/bootstrap/routes.php';
