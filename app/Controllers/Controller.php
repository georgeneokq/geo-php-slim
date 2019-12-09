<?php

namespace App\Controllers;
use Psr\Container\ContainerInterface;

class Controller
{
    /*
     * Eloquent database
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected $db;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->db = $container->get('db');
        $this->view = $container->get('view');
    }

    protected function encode($content) {
        return json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
