<?php
namespace app\model\dao;

use app\database\DatabaseConnection;
use app\model\entity\Usuario;
use app\model\entity\Cargo;

class CargoDAO extends DAO{    
    private $table_name="cargos"; 
    

    function __construct(DatabaseConnection $connection){
    
        parent::__construct($connection,$this->table_name);
    }

    
    function get(){
        $stmt = parent::get();        
        $cargos=array();
        while($cargo = $stmt->fetchObject(Cargo::class)){
            $serialized = $cargo->jsonSerialize();
            array_push($cargos,$serialized);
        }
        return $cargos; 
    }



}
?>