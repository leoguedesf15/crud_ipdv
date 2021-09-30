<?php

    // Driblando CORS
    header("Access-Control-Allow-Origin: *");
     if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
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