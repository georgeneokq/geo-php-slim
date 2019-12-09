<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class RemoveTrailingSlash extends Middleware
{
    /*
     * @param   ServerRequestInterface $request PSR-7 request
     * @param   RequestHandler $handler PSR-15 request handler
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if ($path != '/' && substr($path, -1) == '/') {
            // permanently redirect paths with a trailing slash
            // to their non-trailing counterpart
            $uri = $uri->withPath(substr($path, 0, -1));

            if ($request->getMethod() == 'GET') {
                $response = new \GuzzleHttp\Psr7\Response(301, ['location' => (string) $uri]);
                return $response;
            } else {
                $request = $request->withUri($uri);
            }
        }

        return $handler->handle($request);
    }
}
