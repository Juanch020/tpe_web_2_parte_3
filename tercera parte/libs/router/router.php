<?php
require_once __DIR__ . '/request.php';
require_once __DIR__ . '/response.php';
require_once __DIR__ . '/route.php';
require_once __DIR__ . '/middleware.php';

class Router {
    private $routeTable = [];
    private $defaultRoute;
    private $request;
    private $response;

    public function __construct() {
        $this->defaultRoute = null;
        $this->request = new Request();
        $this->response = new Response();
    }

    public function route($url, $verb) {
        foreach ($this->routeTable as $route) {
            if ($route->match($url, $verb)) {
                $route->run($this->request, $this->response);
                if($this->response->hasFinished())
                    return;
            }
        }
        if ($this->defaultRoute != null) {
            $this->defaultRoute->run($this->request, $this->response);
        }else {
            $this->response->json(['error' => 'Endpoint no encontrado'], 404);
        }
    }
    
    public function addMiddleware($middleware) {
        $this->routeTable[] = $middleware;
    }
    
    public function addRoute ($url, $verb, $controller, $method) {
        $this->routeTable[] = new Route($url, $verb, $controller, $method);
    }

    public function setDefaultRoute($controller, $method) {
        $this->defaultRoute = new Route("", "", $controller, $method);
    }
}
?>