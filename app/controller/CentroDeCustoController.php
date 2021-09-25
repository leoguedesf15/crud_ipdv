<?php
namespace app\controller;

use app\controller\IController;
use app\controller\ApiController;
use app\model\entity\Usuario;
use app\model\service\CentroDeCustoService;

class CentroDeCustoController implements IController{
     private $apiController;
     function __construct(){
          $this->apiController = new ApiController();
     }

     function index(){          
          $this->apiController->index(new CentroDeCustoService());
     } 
     function show($id){
          $this->apiController->show($id, new CentroDeCustoService());
     }    
     function update($id){          
          $this->apiController->update($id,new CentroDeCustoService());         
     }
     function destroy($id){
         $this->apiController->destroy($id,new CentroDeCustoService());
     }
     function store(){                 
          $this->apiController->store($_POST,new CentroDeCustoService()); 
     }


     
}
?>