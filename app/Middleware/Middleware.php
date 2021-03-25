<?php

namespace App\Middleware;

class Middleware
{
    public function __construct()
    {
    }

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
