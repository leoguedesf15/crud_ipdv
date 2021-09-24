<?php
namespace app\model\dao;

use app\database\DatabaseConnection;
use app\model\entity\Usuario;
use app\model\entity\Cargo;

class UsuarioDAO extends DAO{    
    private $table_name="usuarios"; 
    private $primaryKey = "id_usuario";
    function __construct(DatabaseConnection $connection){
        $this->classesJoint = array();
        parent::__construct($connection,$this->table_name);
    }
    
    
    function get(){
        $stmt = parent::get();               
        $usuarios=array();
        while($usuario = $stmt->fetchObject(Usuario::class)){
            $serialized = $usuario->jsonSerialize();
            array_push($usuarios,$serialized);
        }
        return $usuarios;
    }

    
  

}
?>