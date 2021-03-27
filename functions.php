<?php
use Psr\Http\Message\ResponseInterface as Response;

function write(Response $response, $content) {
    $response->getBody()->write($content);
}

/*
 * Appends the public directory path to the parameter
 */
function publicPath($path) {
    if(substr($path, 0, 1) != '/') {
        return PUBLIC_PATH . '/' . $path;
    }
    return PUBLIC_PATH . $path;
}

/*
 * Appends the public upload directory path to the parameter.
 * By default, the directory would be empty. Check if the directory exists and create it if it doesn't.
 */
function uploadsPath($path) {
    if(!is_dir(UPLOADS_PATH)) {
        mkdir(UPLOADS_PATH, 0777, true);
    }
    if(substr($path, 0, 1) != '/') {
        return UPLOADS_PATH . '/' . $path;
    }
    return UPLOADS_PATH . $path;
}

/*
 * Appends the server directory path to the parameter
 */
function serverPath($path) {
    if(substr($path, 0, 1) != '/') {
        return SERVER_PATH . '/' . $path;
    }
    return PUBLIC_PATH . $path;
}