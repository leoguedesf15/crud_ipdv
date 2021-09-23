<?php

use app\route\RouteController;

include_once '../app/inc/bootstrap.php';
    //header('Content-Type: application/json');
    $url= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $route = RouteController::matchRoute($url,$_SERVER["REQUEST_METHOD"]);
    $action = $route->getAction();
    $controller = $route->getController();
    $controller->$action();   
?>