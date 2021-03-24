<?php
namespace App\Controllers;

use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsersController extends Controller
{
    public function signup(Request $request, Response $response) {
        $body = $request->getParsedBody();
        // Get email, name, password
        $email = $body['email'];
        $name = $body['name'];
        $password = $body['password'];

        // Create user model and save to database
        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        
        if($user->save()) {
            $response->getBody()->write($this->encode([
                'err' => 0
            ]));
            return $response;
        } else {
            $response->getBody()->write($this->encode([
                'err' => 1,
                'msg' => 'An error has occurred.'
            ]));
            return $response;
        }
    }

    public function login(Request $request, Response $response) {
        $body = $request->getParsedBody();
        // Get email and password
        $email = $body['email'];
        $password = $body['password'];

        // Get model by email
        $user = User::where('email', $email)->first();

        if($user) {
            // Check hash
            if(password_verify($password, $user->password)) {
                // Return token as well as account info (except password)
                $token = password_hash($user->password, PASSWORD_BCRYPT);
                $user->token = $token;
                $user->save();
                $response->getBody()->write($this->encode([
                    'err' => 0,
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name
                    ]
                ]));
            } else {
                $response->getBody()->write($this->encode([
                    'err' => 1,
                    'msg' => 'Wrong password'
                ]));
            }
        } else {
            $response->getBody()->write($this->encode([
                'err' => 1,
                'msg' => 'No such account'
            ]));
        }
        return $response;
    }

    public function logout(Request $request, Response $response) {
        $body = $request->getParsedBody();
        // Get the token
        $token = $body['token'];
        $user = User::where(DB::raw('BINARY `token`'), $token)->first();

        if($user) {
            $user->token = null;
            $user->save();
            $response->getBody()->write($this->encode([
                'err' => 0
            ]));
        } else {
            $response->getBody()->write($this->encode([
                'err' => 1,
                'msg' => 'Invalid token'
            ]));
        }

        return $response;
    }
}
