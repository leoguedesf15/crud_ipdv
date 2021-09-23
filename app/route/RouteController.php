<?php
namespace app\route;
use app\route\Route;

class RouteController{
    
    static function addRoute($path, $controllerClass,$action,$method){
        $route = new Route($method,$action, new $controllerClass,$path,mb_strpos($path,"$1"));        
        array_push($GLOBALS["routes"],$route);
        
    }

    static function initialize(){
        $GLOBALS["routes"]=array();
    }
    static function matchRoute($url,$method){
        $routes = $GLOBALS["routes"];
        $path = RouteController::extractPathFromUrl($url);
        $splitPath = explode("/",$path);
        $hasParams=isset($splitPath[3]);
        foreach($routes as $route){
            if($route->getPath() == $path && $route->getMethod() == $method && $route->hasParams() == $hasParams){
                return $route;
            }
        }
        return null;
    }

    private static function extractPathFromUrl($url){
        return substr($url,strlen(BASE_URL));
    }
    
}
?>