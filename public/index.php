<?php

use app\route\RouteController;

include_once '../app/inc/bootstrap.php';
    header('Content-Type: application/json');
    $url= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $route = RouteController::matchRoute($url,$_SERVER["REQUEST_METHOD"]);
    if(isset($route)){
        $action = $route->getAction();
        $controller = $route->getController();
        if($route->hasParams()){
            $path = RouteController::extractPathFromUrl($url);
            $splitPath = explode("/",$path);
            $paramId=$splitPath[2];
            $controller->$action($paramId);
        }else{
            $controller->$action();   
        }
    }    
?>