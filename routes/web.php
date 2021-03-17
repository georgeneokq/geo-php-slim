<?php

/*
 * Web routes
 * Routes that are meant to return resources to the browser
 */

/* 
 * Controller namespace shorthand 'C' for convenience
 * C.'MyController:home' in full is 'App\Controllers\MyController:home'
 */

$app->get('/', C.'WebController:home');