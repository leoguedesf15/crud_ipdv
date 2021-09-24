<?php
namespace app\controller;

use app\controller\IController;
use app\controller\ApiController;
use app\model\entity\Usuario;
use app\model\service\UsuarioService;

class UsuarioController implements IController{
    
     function index(){          
          $apiController = new ApiController();
          $apiController->index(new UsuarioService());
     } 
     function show($id){
          $apiController = new ApiController;
          $apiController->show($id, new UsuarioService());
     }    
     function update($id){
          $body=file_get_contents('php://input');        
          $payload = ApiController::handle_put_payload($body);
          $servico = new UsuarioService();          
     }
     function destroy($id){

     }
     function create(){
          echo 'MÉTDOO CCREATE';
     }
     
}
?>