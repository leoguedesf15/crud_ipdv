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
    

    
    public function get_id_usuario(){
        return $this->id_usuario;
    }
    public function get_nome(){
        return $this->nome;
    }
    public function get_email(){
        return $this->email;
    }
    public function get_senha(){
        return $this->senha;
    }
    public function get_dtnascimento(){
        return $this->dtnascimento;
    }
    public function get_id_cargo_fk(){
        return $this->id_cargo_fk;
    }
    public function get_id_departamento_fk(){
        return $this->id_departamento_fk;
    }
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

}

?>