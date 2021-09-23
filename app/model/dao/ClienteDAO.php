<?php
namespace app\model\dao;

use app\database\DatabaseConnection;

class ClienteDAO extends DAO{    
    private $table_name="clientes";    
    function __construct(DatabaseConnection $connection){
        parent::__construct($connection,$this->table_name);
    }
}
?>