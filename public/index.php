<?php

use app\route\RouteController;
//A APLICAÇÃO FOI MONTADA SOB O PADRÃO ARQUITETURAL MVC
//Busca também adaptar alguns padrões comportamentais e criacionais ao longo de sua implementação!
//Arquitetura do Software é escalar!
//o index está na pasta public na intenção de não ceder acesso à raiz da aplicação 
//(em produção seria setado um VHost pra public)
//Na raiz do projeto foi posto um .htaccess bem simples com Options -Indexes para que não seja acessado 
//o diretório da aplicação através do browser
//Mais comentários em cada classe...
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