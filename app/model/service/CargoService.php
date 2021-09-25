<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\CargoDAO;
use app\model\entity\Cargo;
use app\model\service\Validation;
class CargoService implements IService{
    private $errosValidacao;
    private $chave = "id_cargo";
    private $validacoes=[
        "id_cargo"=>"required",
        "nome_cargo"=>"required|length:30",
        "descricao"=>"required|length:30"
    ];
    public $controller;
    public function all(){
       try{
           $dao = new CargoDAO(new DatabaseConnection());
           $users = $dao->selectAll()->get();
           return $users;
       } catch(Exception $ex){
           $this->lancarExcecao($ex);
       }        
    }

    public function find($id){
        try{
        $dbCon = new DatabaseConnection();
        $cargoDAO = new CargoDAO($dbCon);
        $userDao = new UsuarioDAO($dbCon);                
        $cargos = $cargoDAO->selectAll()->where(" ".$this->chave."=".$id)->get();
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
            $cargoDAO = new CargoDAO(new DatabaseConnection());
            $setStr="   
            nome_cargo='".$payload["nome_cargo"]."',
            descricao='".$payload["descricao"]."'
            ";
            return $cargoDAO->update($setStr)->where(" ".$this->chave."=".$id)->generic(";")->execute();
            
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
                $cargoDAO = new CargoDAO(new DatabaseConnection());
                return $cargoDAO->delete()->where(" ".$this->chave." = ".$id)->generic(";")->execute();
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
                $cargoDAO = new CargoDAO(new DatabaseConnection());
                if($cargoDAO->insertInto($cargo,$this->chave)->execute()){
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