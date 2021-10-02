<?php

use app\controller\ApiController;
use app\controller\AuthController;
use app\controller\CargoController;
use app\controller\CentroDeCustoController;
use app\controller\DepartamentoController;
use app\controller\UsuarioController;
    use app\route\RouteController;
    RouteController::initialize();
    
    RouteController::addRoute('/login',AuthController::class,'login','POST');
    RouteController::addRoute('/validar-token',AuthController::class,'endPointValidacaoToken','POST');

    RouteController::addRoute('/upload',UsuarioController::class,'uploadInsert','POST');

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

    RouteController::addRoute('/departamento',DepartamentoController::class,'index','GET');
    RouteController::addRoute('/departamento/$',DepartamentoController::class,'show','GET');
    RouteController::addRoute('/departamento',DepartamentoController::class,'store','POST');
    RouteController::addRoute('/departamento/$',DepartamentoController::class,'update','PUT');
    RouteController::addRoute('/departamento/$',DepartamentoController::class,'destroy','DELETE');

    RouteController::addRoute('/centro-de-custo',CentroDeCustoController::class,'index','GET');
    RouteController::addRoute('/centro-de-custo/$',CentroDeCustoController::class,'show','GET');
    RouteController::addRoute('/centro-de-custo',CentroDeCustoController::class,'store','POST');
    RouteController::addRoute('/centro-de-custo/$',CentroDeCustoController::class,'update','PUT');
    RouteController::addRoute('/centro-de-custo/$',CentroDeCustoController::class,'destroy','DELETE');
?>