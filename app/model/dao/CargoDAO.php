<?php
namespace app\model\dao;

use app\database\DatabaseConnection;
use app\model\entity\Usuario;
use app\model\entity\Cargo;
use ErrorException;
class CargoDAO extends DAO{    
    private $table_name="cargos"; 
    

    function __construct(DatabaseConnection $connection){
    
        parent::__construct($connection,$this->table_name);
    }

    
    function get(){
        $stmt = parent::get();     
        if(!isset($stmt)) throw new ErrorException("Erro ao buscar registro no banco de dados!");    
        $cargos=array();
        while($cargo = $stmt->fetchObject(Cargo::class)){
            $serialized = $cargo->jsonSerialize();
            array_push($cargos,$serialized);
        }
        return $cargos; 
    }



}
?>