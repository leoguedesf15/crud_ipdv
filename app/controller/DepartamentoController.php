<?php
namespace app\controller;

use app\controller\IController;
use app\controller\ApiController;
use app\model\service\DepartamentoService;

class DepartamentoController implements IController{
     private $apiController;
     function __construct(){
          $this->apiController = new ApiController();
     }
     function index(){          
          $this->apiController->index(new DepartamentoService());
     } 
     function show($id){
          $this->apiController->show($id, new DepartamentoService());
     }    
     function update($id){          
          $this->apiController->update($id,new DepartamentoService());         
     }
     function destroy($id){
         $this->apiController->destroy($id,new DepartamentoService());
     }
     function store(){                 
          $this->apiController->store($_POST,new DepartamentoService()); 
     }


     
}
?>