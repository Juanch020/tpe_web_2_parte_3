<?php
require_once __DIR__ . '/request.php';
require_once __DIR__ . '/response.php';
require_once __DIR__ . '/routable.php';

abstract class Middleware extends Routable{
    public function match($url, $verb){
        return true;
    }
    abstract public function run($request, $response);
}
?>