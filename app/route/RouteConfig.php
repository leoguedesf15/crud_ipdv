<?php
    use app\controller\UsuarioController;
    use app\route\RouteController;
    RouteController::initialize();
    RouteController::addRoute('/usuario',UsuarioController::class,'index','GET');
    RouteController::addRoute('/usuario/$',UsuarioController::class,'show','GET');
    RouteController::addRoute('/usuario',UsuarioController::class,'create','POST');
    RouteController::addRoute('/usuario',UsuarioController::class,'update','PUT');
    RouteController::addRoute('/usuario/$',UsuarioController::class,'destroy','DELETE');
?>