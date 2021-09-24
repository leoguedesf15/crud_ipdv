<?php
namespace app\controller;

use app\controller\IController;
use app\controller\ApiController;
use app\model\service\UsuarioService;

class UsuarioController implements IController{
    
    function index(){
         UsuarioService::all();   
        
    } 
    function show($params){
          
     }    
     function update($params){
        $body=file_get_contents('php://input');        
        $params = ApiController::handle_put_payload($body);
        $servico = new UsuarioService();          
     }
     function destroy($params){

     }
     
}
?>