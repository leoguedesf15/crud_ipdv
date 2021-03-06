<?php
namespace app\model\dao;
use app\database\DatabaseConnection;
use app\model\entity\Usuario;
use ErrorException;

abstract class DAO{
    // Nesta classe foi usada uma adaptação do padrão de projetos Builder para construção das queries com mais facilidade,
    // organização e prevenção de reescrita de código desnecessário.
    // O builder neste caso está sendo consumido pela camada de serviços, aonde está toda a lógica de negócios da aplicação.
    private $connection;
    protected $query;
    private $table_name;
    public function __construct(DatabaseConnection $conn,$table_name){
        $this->connection  = $conn;
        $this->table_name = $table_name;
        $this->query="";
    }
    
    function selectAll(){
        $this->query="Select * from ".$this->table_name." ";
        return $this;        
    }
    function select($arrayAtributtes){
        $this->query="Select ".implode(',',$arrayAtributtes)." from ".$this->table_name." ";
        return $this;
    }
    function update($setStr){
        $this->query="UPDATE ".$this->table_name." SET ".$setStr;
        return $this;
    }
    function insertInto($obj,$primaryKey){
       
        $arrChaves = $obj->getClassVars();
        unset($arrChaves[0]);
        $data = $obj->jsonSerialize();
        unset($data[$primaryKey]);       
        $this->query = "INSERT INTO ".$this->table_name." (".implode(",",$arrChaves).") VALUES ('".implode("','",$data)."');";        
        return $this;
    }
    
    function delete(){
        $this->query = " DELETE FROM ".$this->table_name." ";
        return $this;
    }
    function where($condition){
        $this->query.=" where ".$condition;
        return $this;
    }
    
    function get() {        
        $this->connection->beginTransaction();            
        $stmt = $this->connection->prepare($this->query);
        if($stmt->execute()){
            $this->connection->commit();
        }else{
            $this->connection->rollBack();
            return null;
        }
        
        return $stmt;        
    }
    
    function execute(){
        $this->connection->beginTransaction();
        $stmt = $this->connection->prepare($this->query);
        if($stmt->execute()){
            $this->connection->commit();
            return true;
        }else{            
            $this->connection->rollBack();
            throw new ErrorException("Erro ao salvar registro no banco de dados!");
        }
    }
    function generic($command){
        $this->query.= " ".$command." ";
        return $this;
    }

}