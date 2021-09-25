<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\CentroDeCustoDAO;
use app\model\entity\Cargo;
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
        $userDao = new UsuarioDAO($dbCon);                
        $cargos = $CentroDeCustoDAO->selectAll()->where(" ".$this->chave."=".$id)->get();
        if(sizeof($cargos)>0){
            $cargo = $cargos[0];     
            $users = $userDao->selectAll()->where(" id_cargo_fk=".$id)->get();
            $cargo["usuarios"] = $users;
            $cargos[0] = $cargo;
            return $cargos;
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
            nome_cargo='".$payload["nome_cargo"]."',
            descricao='".$payload["descricao"]."'
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
        $payload["id_cargo"] = "DEFAULT";
        try{
            if($this->validaPayload($payload)){
                $cargo = new Cargo();
                $cargo->setNome_cargo($payload["nome_cargo"]);
                $cargo->setDescricao($payload["descricao"]);
                $CentroDeCustoDAO = new CentroDeCustoDAO(new DatabaseConnection());
                if($CentroDeCustoDAO->insertInto($cargo,$this->chave)->execute()){
                    return $cargo->jsonSerialize();
                }else{
                    return $this->controller->stopExecution("Erro ao salvar Cargo!");
                }            
            }else{
                $this->controller->stopExecution("Parâmetros inválidos!",[],$this->errosValidacao,400);
            }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }  
    }
    public function validarRemocao($id){
        $cargos = $this->find($id);
        $this->errosValidacao=array();
        $cargo=$cargos[0];
        if(sizeof($cargo["usuarios"])>0){
            array_push($this->errosValidacao,"Existem usuários relacionados!");
        }
        return sizeof($this->errosValidacao)==0;
    }
    public function validaPayload($payload){
        $this->errosValidacao = array();
        $cargo = new Cargo();
        $validation = new Validation();
        foreach($cargo->getClassVars() as $var){ 
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