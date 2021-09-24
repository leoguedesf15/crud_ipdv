<?php
namespace app\controller;

use app\controller\IController;
use app\controller\ApiController;
use app\model\entity\Usuario;
use app\model\service\CargoService;

class CargoController implements IController{
     private $apiController;
     function __construct(){
          $this->apiController = new ApiController();
     }

     function index(){          
          $this->apiController->index(new CargoService());
     } 
     function show($id){
          $this->apiController->show($id, new CargoService());
     }    
     function update($id){          
          $this->apiController->update($id,new CargoService());         
     }
     function destroy($id){
         $this->apiController->destroy($id,new CargoService());
     }
     function store(){                 
          $this->apiController->store($_POST,new CargoService()); 
     }


     
}
?>