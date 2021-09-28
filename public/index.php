<?php

    // Driblando CORS
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding, Referer, sec-ch-ua, sec-ch-ua-mobile,sec-ch-ua-platform,User-Agent");

use app\route\RouteController;

include_once '../app/inc/bootstrap.php';
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