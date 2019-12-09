<?php


/*
 * API routes
 * Typical way to return data
 *
 * 1. Get data from data source
 * 2. Encode the data into a json string using json_encode
 * 3. Write the json string into the response body using $response->getBody()->write()
 * 4. Return the response object
 */

use Slim\Routing\RouteCollectorProxy;

// Controller namespace shorthand for convenience

$app->group('/api', function(RouteCollectorProxy $group) {
    //  version 1 api routes
    $group->group('/v1', function(RouteCollectorProxy $group) {

        $group->get('/products', C.'ProductsController:getAllProducts');

        $group->post('/users/signup', C.'UsersController:signup');
        $group->post('/users/login', C.'UsersController:login');
        $group->post('/users/logout', C.'UsersController:logout');

        // Requires token authentication
        $group->group('', function(RouteCollectorProxy $group) {
            $group->post('/orders', C.'OrdersController:createOrder');
            $group->get('/{user_id}/orders', C.'OrdersController:getOrdersByUserId');
        })->add(AuthToken::class);
    });
});
