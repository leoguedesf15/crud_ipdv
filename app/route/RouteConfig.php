<?php

use app\controller\CargoController;
use app\controller\UsuarioController;
    use app\route\RouteController;
    RouteController::initialize();
    RouteController::addRoute('/usuario',UsuarioController::class,'index','GET');
    RouteController::addRoute('/usuario/$',UsuarioController::class,'show','GET');
    RouteController::addRoute('/usuario',UsuarioController::class,'store','POST');
    RouteController::addRoute('/usuario/$',UsuarioController::class,'update','PUT');
    RouteController::addRoute('/usuario/$',UsuarioController::class,'destroy','DELETE');

    RouteController::addRoute('/cargo',CargoController::class,'index','GET');
    RouteController::addRoute('/cargo/$',CargoController::class,'show','GET');
    RouteController::addRoute('/cargo',CargoController::class,'store','POST');
    RouteController::addRoute('/cargo/$',CargoController::class,'update','PUT');
    RouteController::addRoute('/cargo/$',CargoController::class,'destroy','DELETE');
?>