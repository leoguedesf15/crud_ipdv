<?php
namespace app\Route;
use app\controller\ClienteController;
class Route{
    private $method;
    private $action;
    private $controller;
    private $path;

    function __construct($method,$action,$controller,$path){
        $this->method = $method;
        $this->action = $action;
        $this->controller = $controller;
        $this->path = $path;
    }

    public function getController(){
        return $this->controller;
    }
    public function getMethod(){
        return $this->method;
    }
    public function getPath(){
        return $this->path;
    }
    public function getAction(){
        return $this->action;
    }

}
?>