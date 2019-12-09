<?php
use Psr\Http\Message\ResponseInterface as Response;

function write(Response $response, $content) {
    $response->getBody()->write($content);
}
