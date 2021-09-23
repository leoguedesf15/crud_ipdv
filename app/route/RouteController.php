<?php
namespace app\route;
use app\route\Route;

class RouteController{
    
    static function addRoute($path, $controllerClass,$action,$method){
        $route = new Route($method,$action, new $controllerClass,$path);
        array_push($_SESSION["routes"],$route);
    }

    static function initialize(){
        $_SESSION["routes"]=array();
    }
    static function matchRoute($path,$method){
        $rotas = $_SESSION["routes"];
        foreach($rotas as $rota){
            if($rota->path == $path && $rota->method == $method){
                return $rota;
            }
        }
        return null;
    }
    
}
?>