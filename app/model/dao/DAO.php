<?php
namespace app\model\dao;
use app\database\DatabaseConnection;
abstract class DAO{
    private $connection;
    private $query;
    private $table_name;
    public function __construct(DatabaseConnection $conn,$table_name){
        $this->connection  = $conn;
        $this->table_name = $table_name;
    }
    
    function selectAll(){
        $this->query="Select * from ".$this->table_name." ";
        return $this;        
    }
    function where($condition){
        $this->query.=" where ".$condition;
        return $this;
    }

    function get(){
        echo $this->query;
        // $this->connection->beginTransaction();
        // $result = $this->connection->query($this->query);
        // $this->connection->commit();
        // return $result;
    }
    function orderBy($arrayOrderBy){
        
    }
    function execute(){
        
    }
}
?>