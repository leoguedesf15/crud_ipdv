<?php
namespace app\model\dao;
use app\database\DatabaseConnection;
use app\model\entity\Usuario;

abstract class DAO{
    private $connection;
    protected $query;
    private $table_name;
    public function __construct(DatabaseConnection $conn,$table_name){
        $this->connection  = $conn;
        $this->table_name = $table_name;
    }
    
    function selectAll(){
        $this->query="Select * from ".$this->table_name." ";
        return $this;        
    }
    function select($arrayAtributtes){
        $this->query="Select ".implode(',',$arrayAtributtes)." from ".$this->table_name." ";
        return $this;
    }
    function where($condition){
        $this->query.=" where ".$condition;
        return $this;
    }
    
    function get(){        
        $this->connection->beginTransaction();
        $stmt = $this->connection->prepare($this->query);
        if($stmt->execute()){
            $this->connection->commit();
        }else{
            $this->connection->rollBack();
            //LANÇAR EXCEÇÃO
        }
        
        return $stmt;        
    }
    function execute(){
        
    }



}
?>