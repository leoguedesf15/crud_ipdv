<?php
    use app\controller\ClienteController;
    use app\route\RouteController;
    RouteController::initialize();
    RouteController::addRoute('/cliente',ClienteController::class,'index','GET');
    RouteController::addRoute('/cliente/$',ClienteController::class,'show','GET');
    RouteController::addRoute('/cliente',ClienteController::class,'create','POST');
    RouteController::addRoute('/cliente',ClienteController::class,'update','PUT');
    RouteController::addRoute('/cliente/$',ClienteController::class,'destroy','DELETE');
?>