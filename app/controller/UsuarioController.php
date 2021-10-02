<?php
namespace app\controller;

use app\controller\IController;
use app\controller\ApiController;
use app\model\entity\Usuario;
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
     function uploadInsert(){
          $fileString = file_get_contents('php://input');
          $strObj= substr($fileString,mb_strpos($fileString,'['),mb_strpos($fileString,']')-mb_strpos($fileString,'[')+1);
          $objs = json_decode($strObj);
          $usuarioService = new UsuarioService();
          foreach($objs as $obj){
               $array_obj=get_object_vars($obj);
               $usuarioService->controller=new ApiController();
               $usuarioService->create($array_obj);
          }          
          $apiResponse = new ApiResponse(true,"Inserção de registros finalizada!",[],[],200);
          $apiResponse->response();

     }


     
}
?>