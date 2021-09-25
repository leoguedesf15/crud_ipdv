<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\CargoDAO;
use app\model\dao\DepartamentoDAO;
use app\model\entity\Usuario;
use Exception;
use app\controller\ApiController;
class UsuarioService implements IService{
    private $errosValidacao;
    private $chave = "id_usuario";
    public ApiController $controller;
    public function all(){        
       try{
           $dao = new UsuarioDAO(new DatabaseConnection());
           $users = $dao->selectAll()->get();
           return $users;
       }catch(Exception $ex){
           $this->lancarExcecao($ex);
       }
    }

    public function find($id){
        $dbCon = new DatabaseConnection();
        $dao = new UsuarioDAO($dbCon);        
        $cargoDAO = new CargoDAO($dbCon);
        $departamentoDAO = new DepartamentoDAO($dbCon);
        try{
            $users = $dao->selectAll()->where(" ".$this->chave."=".$id)->get();
            if(sizeof($users)>0){
                $user = $users[0];     
                $cargo = $cargoDAO->selectAll()->where(" id_cargo=".$user["id_cargo_fk"])->get();
                $departamento = $departamentoDAO->selectAll()->where(" id_departamento=".$user["id_departamento_fk"])->get();
                $user["cargo"] = $cargo[0];
                $user["departamento"] = $departamento[0];
                $users[0]=$user;
                return $users;
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
                $userDao = new UsuarioDAO(new DatabaseConnection());
                $setStr="   
                nome = '".$payload["nome"]."',
                email = '".$payload["email"]."',
                senha = '".$payload["senha"]."',
                dtnascimento = '".$payload["dtnascimento"]."',
                id_cargo_fk = '".$payload["id_cargo_fk"]."',
                id_departamento_fk = '".$payload["id_departamento_fk"]."' ";            
                return $userDao->update($setStr)->where(" ".$this->chave."=".$id)->generic(";")->execute();
                
            }else{
                $this->controller->stopExecution("Parâmetros inválidos!",[],$this->errosValidacao,400);
            }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }
    }

    public function destroy($id){
        try{
            $userDao = new UsuarioDAO(new DatabaseConnection());
            return $userDao->delete()->where(" ".$this->chave." = ".$id)->generic(";")->execute();
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }
    }

    public function create($payload){

        $payload["id_usuario"] = "DEFAULT";
        try{
            if($this->validaPayload($payload)){
                $usuario = new Usuario();       
                $usuario->setNome($payload["nome"]);
                $usuario->setEmail($payload["email"]);
                $usuario->setSenha($payload["senha"]);
                $usuario->setDtnascimento($payload["dtnascimento"]);
                $usuario->setId_cargo_fk($payload["id_cargo_fk"]);
                $usuario->setId_departamento_fk($payload["id_departamento_fk"]);
                $userDao = new UsuarioDAO(new DatabaseConnection());
                if($userDao->insertInto($usuario,$this->chave)->execute()){
                    return $usuario->jsonSerialize();
                }else{
                    return $this->controller->stopExecution("Erro ao salvar Usuário!");
                }            
            }else{
                $this->controller->stopExecution("Parâmetros inválidos!",[],$this->errosValidacao,400);
            }
        }catch(Exception $ex){
            $this->lancarExcecao($ex);
        }
    }

    public function validaPayload($payload){
        $this->errosValidacao = array();
        $usuario = new Usuario();
        foreach($usuario->getClassVars() as $var){
            if(!isset($payload[$var]) || $payload[$var]==""){
                array_push($this->errosValidacao,$var);
            }
        }
        return sizeof($this->errosValidacao)==0;
    }

    private function lancarExcecao($ex){
        $this->controller->stopExecution($ex->getMessage());
    }
    

}
?>