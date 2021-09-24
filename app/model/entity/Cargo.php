<?php
namespace app\model\entity;

use JsonSerializable;

class Cargo implements JsonSerializable{
    private $id_cargo;	
    private $nome_cargo;	
    private $descricao;
    
    public function getId_cargo(){
        return $this->id_cargo;
    }	
    public function getNome_cargo(){
        return $this->nome_cargo;
    }	
    public function getDescricao(){
        return $this->descricao;
    }
    public function setNome_cargo($nome_cargo){
        $this->nome_cargo=$nome_cargo;
    }
    public function setDescricao($descricao){
        $this->descricao=$descricao;
    }
    
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
    public function getClassVars(){
        return array_keys(get_class_vars(get_class($this)));
    }
    
}