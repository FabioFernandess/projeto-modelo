<?php

declare(strict_types=1);

use App\Middleware\AclMiddleware;
use App\Service\Settings;
use DI\ContainerBuilder;
use Slim\App;

// Set the absolute path to the root directory.
$rootPath = realpath(__DIR__ . '/..');

// Include the composer autoloader.
include_once $rootPath . '/vendor/autoload.php';

// At this point the container has not been built. We need to load the settings manually.
$settings = Settings::load();

// DI Builder
$containerBuilder = new ContainerBuilder();

if (! $settings->get('debug')) {
    // Compile and cache container.
    $containerBuilder->enableCompilation($settings->get('cache_dir').'/container');
}

// Set up dependencies
$containerBuilder->addDefinitions($rootPath.'/config/dependencies.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
$app = \DI\Bridge\Slim\Bridge::create($container);

$container->set(App::class, function () use($app) {
    return $app;
});
// Register middleware
$authMiddleware = new AclMiddleware($container);
$app->add($authMiddleware);



// Register middleware
$middleware = require $rootPath . '/config/middleware.php';
$middleware($app);

// Register routes
$routes = require $rootPath . '/config/routes.php';
$routes($app);

// Set the cache file for the routes. Note that you have to delete this file
// whenever you change the routes.
if (! $settings->get('debug')) {
    $app->getRouteCollector()->setCacheFile($settings->get('cache_dir').'/route');
}

// Add the routing middleware.
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Run the app
$app->run();
