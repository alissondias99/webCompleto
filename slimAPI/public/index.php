<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

//echo __DIR__; mostra o local em que o projeto está salvo

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dependencies = require __DIR__ . '/../src/dependencies.php';
if (is_callable($dependencies)) {
    $dependencies($app);
}

$container = $app->getContainer();
$container->get('db');

// Register middleware
$middleware = require __DIR__ . '/../src/middleware.php';
if (is_callable($middleware)) {
    $middleware($app);
}

// Register routes
$routes = require __DIR__ . '/../src/routes.php';
if (is_callable($routes)) {
    $routes($app);
}

// Run app
$app->run();
