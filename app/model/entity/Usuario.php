<?php
namespace app\model\entity;
class Usuario{
    private $idUsuario;
    private $nome;
    private $cpf;

    function __construct($idUsuario,$nome,$cpf){
        $this->idUsuario = $idUsuario;
        $this->nome=$nome;
        $this->cpf=$cpf;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getCpf(){
        return $this->cpf;
    }
}

?>