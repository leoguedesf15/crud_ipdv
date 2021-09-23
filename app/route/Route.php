<?php
namespace app\Route;
use app\controller\ClienteController;
class Route{
    private $method;
    private $action;
    private $controller;
    private $path;
    private $hasParams;
    
    function __construct($method,$action,$controller,$path,$hasParams){
        $this->method = $method;
        $this->action = $action;
        $this->controller = $controller;
        $this->path = $path;
        $this->hasParams=$hasParams;
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

    public function hasParams(){
        $this->setHasParams=true;
    }
}
?>