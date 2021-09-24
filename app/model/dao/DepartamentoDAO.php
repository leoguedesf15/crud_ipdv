<?php
namespace app\model\dao;

use app\database\DatabaseConnection;
use app\model\entity\Usuario;
use app\model\entity\Departamento;

class DepartamentoDAO extends DAO{    
    private $table_name="departamentos"; 
    

    function __construct(DatabaseConnection $connection){
    
        parent::__construct($connection,$this->table_name);
    }

    
    function get(){
        $stmt = parent::get();
        $departamentos=array();
        while($departamento = $stmt->fetchObject(Departamento::class)){
            $serialized = $departamento->jsonSerialize();
            array_push($departamentos,$serialized);
        }
        return $departamentos;
    }



}
?>