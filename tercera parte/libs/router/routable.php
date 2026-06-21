<?php
require_once __DIR__ . '/request.php';
require_once __DIR__ . '/response.php';

abstract class Routable{
    abstract function run ($request, $response);
}
?>