<?php 
    include_once '../app/inc/bootstrap.php';
    header('Content-Type: application/json');
    $routes = $_SESSION["routes"];  
    $route = $routes[0];
    $action = $route->getAction();
    $controller = $route->getController();
    $controller->$action([]);   
?>