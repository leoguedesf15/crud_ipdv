<?php
namespace app\model\dao;

use app\database\DatabaseConnection;

class UsuarioDAO extends DAO{    
    private $table_name="usuarios";    
    function __construct(DatabaseConnection $connection){
        parent::__construct($connection,$this->table_name);
    }
}
?>