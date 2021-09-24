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
          
          $apiController = new ApiController();
          $apiController->update($id,new UsuarioService());         
     }
     function destroy($id){
         $apiController = new ApiController();
         $apiController->destroy($id,new UsuarioService());
     }
     function create(){
          echo 'MÉTDOO CCREATE';
     }


     
}
?>