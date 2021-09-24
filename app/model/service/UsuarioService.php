<?php
namespace app\model\service;

use app\controller\ApiController;
use app\controller\ApiResponse;
use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\CargoDAO;
use app\model\dao\DepartamentoDAO;
use app\model\entity\Usuario;
use app\utils\Utils;

class UsuarioService implements IService{
    private static $errosValidacao;
    private static $chave = "id_usuario";
    public static function all(){        
       $dao = new UsuarioDAO(new DatabaseConnection());
       $users = $dao->selectAll()->get();
       return $users;
    }

    public static function find($id){
        $dbCon = new DatabaseConnection();
        $dao = new UsuarioDAO($dbCon);        
        $cargoDAO = new CargoDAO($dbCon);
        $departamentoDAO = new DepartamentoDAO($dbCon);
        $users = $dao->selectAll()->where(" ".UsuarioService::$chave."=".$id)->get();
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
    }

    public static function update($id, $payload){
        $payload[UsuarioService::$chave] = $id;
        if(UsuarioService::validaPayload($payload)){
            $userDao = new UsuarioDAO(new DatabaseConnection());
            $setStr="   
            nome = '".$payload["nome"]."',
            email = '".$payload["email"]."',
            senha = '".$payload["senha"]."',
            dtnascimento = '".$payload["dtnascimento"]."',
            id_cargo_fk = '".$payload["id_cargo_fk"]."',
            id_departamento_fk = '".$payload["id_departamento_fk"]."' ";            
            return $userDao->update($setStr)->where(" ".UsuarioService::$chave."=".$id)->generic(";")->execute();
            
        }else{
            $apiController = new ApiController();
            $apiController->stopExecution("Parâmetros inválidos!",[],UsuarioService::$errosValidacao,400);
        }
    }

    public static function destroy($id){
        $userDao = new UsuarioDAO(new DatabaseConnection());
        return $userDao->delete()->where(" ".UsuarioService::$chave." = ".$id)->generic(";")->execute();
    }

    public static function create($payload){
        $payload["id_usuario"] = "DEFAULT";
        $apiController = new ApiController();
        if(UsuarioService::validaPayload($payload)){
            $usuario = new Usuario();       
            $usuario->setNome($payload["nome"]);
            $usuario->setEmail($payload["email"]);
            $usuario->setSenha($payload["senha"]);
            $usuario->setDtnascimento($payload["dtnascimento"]);
            $usuario->setId_cargo_fk($payload["id_cargo_fk"]);
            $usuario->setId_departamento_fk($payload["id_departamento_fk"]);
            $userDao = new UsuarioDAO(new DatabaseConnection());
            if($userDao->insertInto($usuario,UsuarioService::$chave)->execute()){
                return $usuario->jsonSerialize();
            }else{
                return $apiController->stopExecution("Erro ao salvar Usuário!");
            }            
        }else{
            $apiController->stopExecution("Parâmetros inválidos!",[],UsuarioService::$errosValidacao,400);
        }
    }

    public static function validaPayload($payload){
        UsuarioService::$errosValidacao = array();
        $usuario = new Usuario();
        foreach($usuario->getClassVars() as $var){
            if(!isset($payload[$var]) || $payload[$var]==""){
                array_push(UsuarioService::$errosValidacao,$var);
            }
        }
        return sizeof(UsuarioService::$errosValidacao)==0;
    }

    

}
?>