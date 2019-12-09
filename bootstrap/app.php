<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;

// Include constants
require(__DIR__ . '/constants.php');

// Prepare app settings
$settings = require(__DIR__ . '/../config.php');

// Create dependency injection container and configure app
$container = new Container();
$container->set('settings', $settings);

// Boot eloquent ORM connection
$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Attach eloquent to container's 'db' property
$container->set('db', function($container) use ($capsule) {
    return $capsule;
});

// Attach PHP renderer to container's 'view' property
$container->set('view', function($container) {
    return new Slim\Views\PhpRenderer(__DIR__ . '/../views/');
});

// Create slim application
$app = AppFactory::createFromContainer($container);

// Change invocation strategy: Routes with named parameters are now assigned their own separate arguments
$routeCollector = $app->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());

/*
 * Declare global route Middleware.
 * Middleware execution is LIFO. Hence, the Middleware to be executed first should be added last.
 */
$app->addBodyParsingMiddleware();
//$app->addRoutingMiddleware();
$app->add(new App\Middleware\RemoveTrailingSlash());

/*
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.
 *
 * Note: This Middleware should be added last. It will not handle any exceptions/errors
 * for Middleware added after it.
 */
$app->addErrorMiddleware(true, true, true);

/*
 * Load routes by requiring the files AFTER $app variable is declared
 */
require_once(__DIR__ . '/../routes/web.php');
require_once(__DIR__ . '/../routes/api.php');

return $app;
