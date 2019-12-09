<?php

namespace App\Middleware;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthToken extends Middleware
{
    /*
     * @param   ServerRequestInterface $request PSR-7 request
     * @param   RequestHandler $handler PSR-15 request handler
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        $isValidToken = false;
        // Check for token
        $body = $request->getParsedBody();
        if($body['token']) {
            $token = $body['token'];
            // Check for user with token
            $user = User::where(DB::raw('BINARY `token`'), $token)->first();
            if($user) {
                return $response;
            }
        }

        // At this point, the token is invalid.
        $response->getBody()->write($this->encode([
            'err' => 1,
            'msg' => 'Invalid token'
        ]));
        return $response;
    }
}
