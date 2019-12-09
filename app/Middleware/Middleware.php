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
}
