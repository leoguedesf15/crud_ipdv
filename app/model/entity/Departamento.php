<?php
namespace app\model\entity;

use JsonSerializable;

class Departamento implements JsonSerializable{
    private $id_departamento;	
    private $nome_departamento;	
    private $id_centro_custo_fk;

    public function getId_departamento(){
        return $this->id_departamento;
    }
    public function getNome_departamento(){
        return $this->nome_departamento;
    }
    public function getId_centro_custo_fk(){
        return $this->id_centro_custo_fk;
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