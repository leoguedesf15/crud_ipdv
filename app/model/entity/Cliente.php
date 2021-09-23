<?php
namespace app\model\entity;
class Cliente{
    private $idCliente;
    private $nome;
    private $cpf;

    function __construct($idCliente,$nome,$cpf){
        $this->idCliente = $idCliente;
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