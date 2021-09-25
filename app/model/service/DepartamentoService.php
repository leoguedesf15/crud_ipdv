<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\CentroDeCustoDAO;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\DepartamentoDAO;
use app\model\entity\Departamento;
use app\model\service\Validation;
class DepartamentoService implements IService{
    private $errosValidacao;
    private $chave = "id_departamento";
    private $validacoes=[
        "id_departamento"=>"required",
        "nome_departamento"=>"required|length:30",
        "id_centro_custo_fk"=>"required"
    ];
    public $controller;
    public function all(){
       try{
           $dao = new DepartamentoDAO(new DatabaseConnection());
           $departamentos = $dao->selectAll()->generic(";")->get();
           return $departamentos;
       } catch(Exception $ex){
           $this->lancarExcecao($ex);
       }        
    }

    public function find($id){
        try{
            $dbCon = new DatabaseConnection();
            $departamentoDAO = new DepartamentoDAO($dbCon);
            $userDao = new UsuarioDAO($dbCon); 
            $centroDeCustoDAO = new CentroDeCustoDAO($dbCon);               
            $departamentos = $departamentoDAO->selectAll()->where(" ".$this->chave."=".$id)->generic(";")->get();
            if(sizeof($departamentos)>0){
                $departamento = $departamentos[0];     
                $users = $userDao->selectAll()->where(" id_departamento_fk=".$id)->get();
                $centro_de_custo = $centroDeCustoDAO->selectAll()->where(" id_centro_custo=".$departamento["id_centro_custo_fk"])->get();
                $departamento["usuarios"] = $users;
                $departamento["centro_de_custo"] = $centro_de_custo[0];
                $departamentos[0] = $departamento;
                return $departamentos;
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
        if($this->validaPayload($payload) && $this->validaInsercao($payload["id_centro_custo_fk"])){
            $departamentoDAO = new DepartamentoDAO(new DatabaseConnection());
            $setStr="   
            nome_departamento='".$payload["nome_departamento"]."',
            id_centro_custo_fk='".$payload["id_centro_custo_fk"]."'
            ";
            return $departamentoDAO->update($setStr)->where(" ".$this->chave."=".$id)->generic(";")->execute();
            
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
                $departamentoDAO = new DepartamentoDAO(new DatabaseConnection());
                return $departamentoDAO->delete()->where(" ".$this->chave." = ".$id)->generic(";")->execute();
            }else{
                $this->controller->stopExecution("Dados relacionados a este registro! Impossível remover!",[],$this->errosValidacao);
            }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }  
    }

    public function create($payload){
        $payload["id_departamento"] = "DEFAULT";
        try{
            if($this->validaPayload($payload) && $this->validaInsercao($payload["id_centro_custo_fk"])){
                $departamento = new Departamento();
                $departamento->setNome_departamento($payload["nome_departamento"]);
                $departamento->setId_centro_custo_fk($payload["id_centro_custo_fk"]);
                $departamentoDAO = new DepartamentoDAO(new DatabaseConnection());
                if($departamentoDAO->insertInto($departamento,$this->chave)->execute()){
                    return $departamento->jsonSerialize();
                }else{
                    return $this->controller->stopExecution("Erro ao salvar Departamento!");
                }            
            }else{
                $this->controller->stopExecution("Parâmetros inválidos!",[],$this->errosValidacao,400);
            }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }  
    }    
    public function validaInsercao($id_centro_custo){
        $centroCustoServico = new CentroDeCustoService();
        return $centroCustoServico->find($id_centro_custo)!=null;
    }
    public function validarRemocao($id){
        $cargos = $this->find($id);
        $this->errosValidacao=array();
        $cargo=$cargos[0];
        if(sizeof($cargo["usuarios"])>0){
            array_push($this->errosValidacao,"Existem dados relacionados!");
        }
        return sizeof($this->errosValidacao)==0;
    }
    public function validaPayload($payload){
        $this->errosValidacao = array();
        $departamento = new Departamento();
        $validation = new Validation();
        foreach($departamento->getClassVars() as $var){ 
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