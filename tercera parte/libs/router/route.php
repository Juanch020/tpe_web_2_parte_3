<?php
require_once __DIR__ . '/request.php';
require_once __DIR__ . '/response.php';
require_once __DIR__ . '/routable.php';

class Route extends Routable{
    
    private $url;
    private $verb;
    private $controller;
    private $method;
    private $params;

    public function __construct($url, $verb, $controller, $method){
        $this->url = $url;
        $this->verb = $verb;
        $this->controller = $controller;
        $this->method = $method;
        $this->params = [];
    }
    public function match($url, $verb) {
        if($this->verb != $verb){
            return false;
        }
        $partsURL = explode("/", trim($url,'/'));
        $partsRoute = explode("/", trim($this->url,'/'));
        if(count($partsRoute) != count($partsURL)){
            return false;
        }
        foreach ($partsRoute as $key => $part) {
            if($part[0] != ":"){
                if($part != $partsURL[$key])
                return false;
            } 
            else
            {
                $this->params[''.substr($part,1)] = $partsURL[$key];
            }
        }
        return true;
    }
    public function run($request, $response){
        $controller = $this->controller;  
        $method = $this->method;
        $request->params = (object) $this->params;
       
        (new $controller())->$method($request, $response);
    }
}
?>

