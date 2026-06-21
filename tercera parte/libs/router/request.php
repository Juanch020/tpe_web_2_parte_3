<?php
class Request {

    public $body;
    public $params;
    public $query;
    public $user;
    public $authorization;

    public function __construct() {

        $this->body = json_decode(file_get_contents('php://input'));

        $this->query = (object) $_GET;

        $this->authorization =
            $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    }
}
?>