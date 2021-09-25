<?php
namespace app\controller;

use app\controller\IController;
use app\controller\ApiController;
use app\model\service\UsuarioService;

class UsuarioController implements IController{
     private $apiController;
     function __construct(){
          $this->apiController = new ApiController();
     }

     function index(){          
          $this->apiController->index(new UsuarioService());
     } 
     function show($id){
          $this->apiController->show($id, new UsuarioService());
     }    
     function update($id){          
          $this->apiController->update($id,new UsuarioService());         
     }
     function destroy($id){
         $this->apiController->destroy($id,new UsuarioService());
     }
     function store(){                 
          $this->apiController->store($_POST,new UsuarioService()); 
     }


     
}
?>