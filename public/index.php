<?php

/*
 * Configure the value of SERVER_ROOT_PATH according to server configuration.
 */
define('SERVER_PATH', __DIR__ . '/..'); // IMPORTANT! THIS PATH SHOULD BE CHANGED ACCORDINGLY DURING PRODUCTION!
define('PUBLIC_PATH', __DIR__);
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');

// Load dependency classes (required for loading of local .env variables)
require_once SERVER_PATH . '/vendor/autoload.php';

// Load variables from .env file (requires Dotenv dependency package)
$dotenv = Dotenv\Dotenv::createImmutable(SERVER_PATH);
$dotenv->load();

// Load helper functions
require_once SERVER_PATH . '/functions.php';

// Bootstrap the backend slim app and retrieve slim app instance
$app = require_once SERVER_PATH . '/bootstrap/app.php';

// Run the app
$app->run();
