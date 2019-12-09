<?php
namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class WebController extends Controller
{
    public function home(Request $request, Response $response)
    {
        $args = ['title' => 'success'];
        return $this->view->render($response, 'home/index.php', $args);
    }
}
