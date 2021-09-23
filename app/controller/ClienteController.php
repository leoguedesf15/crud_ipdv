<?php
namespace app\controller;
use stdClass;
class ClienteController extends BaseController{
    
     function show($params){
        $classeTeste = new StdClass();
        $classeTeste->nome = "teste";        
        echo json_encode($classeTeste);
    }
}
?>