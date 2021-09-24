<?php
namespace app\model\dao;

use app\database\DatabaseConnection;
use app\model\entity\Usuario;
use app\model\entity\CentroDeCusto;

class CentroDeCustoDAO extends DAO{    
    private $table_name="centros_de_custo"; 
    

    function __construct(DatabaseConnection $connection){
    
        parent::__construct($connection,$this->table_name);
    }

    
    function get(){
        $stmt = parent::get();
        $centrodecustos=array();
        while($centrodecusto = $stmt->fetchObject(CentroDeCusto::class)){
            $serialized = $centrodecusto->jsonSerialize();
            array_push($centrodecustos,$serialized);
        }
        return $centrodecustos; 
    }



}
?>