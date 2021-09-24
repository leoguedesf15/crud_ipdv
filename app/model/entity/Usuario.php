<?php
namespace app\model\entity;

use JsonSerializable;
use app\model\entity\Cargo;
use app\model\entity\Departamento;
class Usuario implements JsonSerializable{
    private $id_usuario;
    private $nome;
    private $email;
    private $senha;
    private $dtnascimento;
    private $id_cargo_fk;
    private $id_departamento_fk;
    
    public function setId_usuario($id_usuario){
        $this->id_usuario=$id_usuario;
    }
    public function setNome($nome){
        $this->nome=$nome;
    }
    public function setEmail($email){
        $this->email=$email;
    }
    public function setSenha($senha){
        $this->senha=$senha;
    }
    public function setDtnascimento($dtnascimento){
        $this->dtnascimento=$dtnascimento;
    }
    public function setId_cargo_fk($id_cargo_fk){
        $this->id_cargo_fk=$id_cargo_fk;
    }
    public function setId_departamento_fk($id_departamento_fk){
        $this->id_departamento_fk=$id_departamento_fk;
    }    
    public function getId_usuario(){
        return $this->id_usuario;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function getDtnascimento(){
        return $this->dtnascimento;
    }
    public function getId_cargo_fk(){
        return $this->id_cargo_fk;
    }
    public function getId_departamento_fk(){
        return $this->id_departamento_fk;
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

?>