<?php

namespace App\Middleware;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Database\Capsule\Manager as DB;
use GuzzleHttp\Psr7\Response;
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
        // Check for token
        $body = $request->getParsedBody();
        $token = $this->get($body, '_token');
        if($token) {
            // Check for user with token
            $user_session = UserSession::where('token', $token)->first();
            if($user_session) {
                return $handler->handle($request);
            }
        }

        // At this point, the token is invalid.
        $response = new Response();
        $response->getBody()->write($this->encode([
            'err' => 1,
            'msg' => 'Invalid token'
        ]));
        return $response;
    }
}
