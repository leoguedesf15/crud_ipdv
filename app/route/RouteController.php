<?php
namespace app\route;

use app\controller\ApiController;
use app\controller\ApiResponse;
use app\route\Route;
use Exception;

class RouteController{
    
    static function addRoute($path, $controllerClass,$action,$method){
        $hasParams = mb_strpos($path,"$")?true:false;
        $p = str_replace("/$","",$path);        
        $route = new Route($method,$action, new $controllerClass,$p,$hasParams);        
        array_push($GLOBALS["routes"],$route);
        
    }

    static function initialize(){
        $GLOBALS["routes"]=array();
    }
    static function matchRoute($url,$method){
        $routes = $GLOBALS["routes"];
        $path = RouteController::extractPathFromUrl($url);
        $splitPath = explode("/",$path);
        $hasParams=isset($splitPath[2])?1:0;
        //removendo o parâmetro para comparação
        $path = "/".$splitPath[1];
        foreach($routes as $route){
            if($route->getPath() == $path && $route->getMethod() == $method && $route->hasParams() == $hasParams){
                return $route;
            }
        }
        $apiController = new ApiController();
        $apiController->stopExecution("Rota não encontrada!",null,null,404);        
    }

    public static function extractPathFromUrl($url){
        return substr($url,strlen(BASE_URL));
    }
    
}
?>