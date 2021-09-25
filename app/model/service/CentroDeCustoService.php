<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\CentroDeCustoDAO;
use app\model\dao\DepartamentoDAO;
use app\model\entity\CentroDeCusto;
use app\model\service\Validation;
class CentroDeCustoService implements IService{
    private $errosValidacao;
    private $chave = "id_centro_custo";
    private $validacoes=[
        "id_centro_custo"=>"required",
        "nome_centro_custo"=>"required|length:30",
    ];
    public $controller;
    public function all(){
       try{
           $dao = new CentroDeCustoDAO(new DatabaseConnection());
           $centrosCusto = $dao->selectAll()->get();
           return $centrosCusto;
       } catch(Exception $ex){
           $this->lancarExcecao($ex);
       }        
    }

    public function find($id){
        try{
        $dbCon = new DatabaseConnection();
        $CentroDeCustoDAO = new CentroDeCustoDAO($dbCon);
        $departamentoDao = new DepartamentoDAO($dbCon);                
        $centrosdecustos = $CentroDeCustoDAO->selectAll()->where(" ".$this->chave."=".$id)->get();
        if(sizeof($centrosdecustos)>0){
            $centro_custo = $centrosdecustos[0];     
            $departamentos = $departamentoDao->selectAll()->where(" id_centro_custo_fk=".$id)->get();
            $centro_custo["departamentos"] = $departamentos;
            $centrosdecustos[0] = $centro_custo;
            return $centrosdecustos;
        }else{
            return null;
        }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }  
    }

    public function update($id, $payload){
        $payload[$this->chave] = $id;
        try{
        if($this->validaPayload($payload)){
            $CentroDeCustoDAO = new CentroDeCustoDAO(new DatabaseConnection());
            $setStr="   
            nome_centro_custo='".$payload["nome_centro_custo"]."'
            ";
            return $CentroDeCustoDAO->update($setStr)->where(" ".$this->chave."=".$id)->generic(";")->execute();
            
        }else{
            $this->controller->stopExecution("Parâmetros inválidos!",[],$this->errosValidacao,400);
        }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }  
    }

    public function destroy($id){
        try{
            if($this->validarRemocao($id)){
                $CentroDeCustoDAO = new CentroDeCustoDAO(new DatabaseConnection());
                return $CentroDeCustoDAO->delete()->where(" ".$this->chave." = ".$id)->generic(";")->execute();
            }else{
                $this->controller->stopExecution("Dados relacionados a este registro! Impossível remover!",[],$this->errosValidacao);
            }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }  
    }

    public function create($payload){
        $payload["id_centro_custo"] = "DEFAULT";
        try{
            if($this->validaPayload($payload)){
                $centroDeCusto = new CentroDeCusto();
                $centroDeCusto->setNome_centro_custo($payload["nome_centro_custo"]);
                $centroDeCustoDAO = new CentroDeCustoDAO(new DatabaseConnection());
                if($centroDeCustoDAO->insertInto($centroDeCusto,$this->chave)->execute()){
                    return $centroDeCusto->jsonSerialize();
                }else{
                    return $this->controller->stopExecution("Erro ao salvar Centro de Custo!");
                }            
            }else{
                $this->controller->stopExecution("Parâmetros inválidos!",[],$this->errosValidacao,400);
            }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }  
    }
    public function validarRemocao($id){
        $centros_de_custo = $this->find($id);
        $this->errosValidacao=array();
        $centro_de_custo=$centros_de_custo[0];
        if(sizeof($centro_de_custo["departamentos"])>0){
            array_push($this->errosValidacao,"Existem dados relacionados!");
        }
        return sizeof($this->errosValidacao)==0;
    }
    public function validaPayload($payload){
        $this->errosValidacao = array();
        $centroDeCusto = new CentroDeCusto();
        $validation = new Validation();
        foreach($centroDeCusto->getClassVars() as $var){ 
            if(isset($this->validacoes[$var])){             
                if(!$validation->validate(isset($payload[$var])?$payload[$var]:null,$this->validacoes[$var])){
                    array_push($this->errosValidacao,$var);
                }
            }
        }        
        return sizeof($this->errosValidacao)==0;
    }

    private function lancarExcecao($ex){
        $this->controller->stopExecution($ex->getMessage());
    }
    

    

}
?>