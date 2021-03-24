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

    /*
     * Encodes an object/array into JSON string.
     * @var $content object/array to encode
     */
    protected function encode($content) {
        return json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /*
     * Gets an array item, with default value of null
     * @var $array array to retrieve value from
     * @var $key array item to get
     */
    protected function get($body, $key) {
        return isset($body[$key]) ? $body[$key] : null;
    }
}
