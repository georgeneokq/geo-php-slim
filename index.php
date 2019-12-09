<?php

/*
 * Configure the value of SERVER_ROOT_PATH according to server configuration.
 */
define('SERVER_ROOT_PATH', __DIR__);

// Load dependency classes (required for loading of local .env variables)
require_once SERVER_ROOT_PATH . '/vendor/autoload.php';

// Load variables from .env file (requires Dotenv dependency package)
$dotenv = Dotenv\Dotenv::createImmutable(SERVER_ROOT_PATH);
$dotenv->load();

// Load helper functions
require_once SERVER_ROOT_PATH . '/functions.php';

// Bootstrap the backend slim app and retrieve slim app instance
$app = require_once SERVER_ROOT_PATH . '/bootstrap/app.php';

// Run the app
$app->run();
