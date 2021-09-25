<?php
namespace app\model\entity;

use JsonSerializable;

class CentroDeCusto implements JsonSerializable{
    private $id_centro_custo;	
    private $nome_centro_custo;

    public function getId_centro_custo(){
        return $this->id_centro_custo;
    }
    public function getNome_centro_custo(){
        return $this->nome_centro_custo;
    }
    public function setId_centro_custo($id_centro_custo){
        $this->$id_centro_custo=$id_centro_custo;
    }
    public function setNome_centro_custo($nome_centro_custo){
        $this->$nome_centro_custo=$nome_centro_custo;
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