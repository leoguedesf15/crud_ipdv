<?php
namespace app\model\service;

use app\controller\ApiController;
use app\controller\ApiResponse;
use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\CargoDAO;
use app\model\dao\DepartamentoDAO;
use app\model\entity\Cargo;
use app\utils\Utils;
use app\model\service\Validation;
class CargoService implements IService{
    private static $errosValidacao;
    private static $chave = "id_cargo";
    private static $validacoes=[
        "id_cargo"=>"required",
        "nome_cargo"=>"required|length:30",
        "descricao"=>"required|length:30"
    ];
    public static function all(){        
       $dao = new CargoDAO(new DatabaseConnection());
       $users = $dao->selectAll()->get();
       return $users;
    }

    public static function find($id){
        $dbCon = new DatabaseConnection();
        $cargoDAO = new CargoDAO($dbCon);
        $userDao = new UsuarioDAO($dbCon);                
        $cargos = $cargoDAO->selectAll()->where(" ".CargoService::$chave."=".$id)->get();
        if(sizeof($cargos)>0){
            $cargo = $cargos[0];     
            $users = $userDao->selectAll()->where(" id_cargo_fk=".$id)->get();
            $cargo["usuarios"] = $users;
            $cargos[0] = $cargo;
            return $cargos;
        }else{
            return null;
        }
    }

    public static function update($id, $payload){
        $payload[CargoService::$chave] = $id;
        if(CargoService::validaPayload($payload)){
            $cargoDAO = new CargoDAO(new DatabaseConnection());
            $setStr="   
            nome_cargo='".$payload["nome_cargo"]."',
            descricao='".$payload["descricao"]."'
            ";
            return $cargoDAO->update($setStr)->where(" ".CargoService::$chave."=".$id)->generic(";")->execute();
            
        }else{
            $apiController = new ApiController();
            $apiController->stopExecution("Parâmetros inválidos!",[],CargoService::$errosValidacao,400);
        }
    }

    public static function destroy($id){
        if(CargoService::validarRemocao($id)){
            $cargoDAO = new CargoDAO(new DatabaseConnection());
            return $cargoDAO->delete()->where(" ".CargoService::$chave." = ".$id)->generic(";")->execute();
        }else{
            $apiController = new ApiController();
            $apiController->stopExecution("Dados relacionados a este registro Impossível remover!",[],CargoService::$errosValidacao);
        }
    }

    public static function create($payload){
        $payload["id_cargo"] = "DEFAULT";
        $apiController = new ApiController();
        if(CargoService::validaPayload($payload)){
            $cargo = new Cargo();
            $cargo->setNome_cargo($payload["nome_cargo"]);
            $cargo->setDescricao($payload["descricao"]);
            $cargoDAO = new CargoDAO(new DatabaseConnection());
            if($cargoDAO->insertInto($cargo,CargoService::$chave)->execute()){
                return $cargo->jsonSerialize();
            }else{
                return $apiController->stopExecution("Erro ao salvar Cargo!");
            }            
        }else{
            $apiController->stopExecution("Parâmetros inválidos!",[],CargoService::$errosValidacao,500);
        }
    }
    public static function validarRemocao($id){
        $cargos = CargoService::find($id);
        CargoService::$errosValidacao=array();
        $cargo=$cargos[0];
        if(sizeof($cargo["usuarios"])>0){
            array_push(CargoService::$errosValidacao,"Existem usuários relacionados!");
        }
    }
    public static function validaPayload($payload){
        CargoService::$errosValidacao = array();
        $cargo = new Cargo();
        $validation = new Validation();
        foreach($cargo->getClassVars() as $var){ 
            if(isset(CargoService::$validacoes[$var])){             
                if(!$validation->validate($payload[$var],CargoService::$validacoes[$var])){
                    array_push(CargoService::$errosValidacao,$var);
                }
            }
        }        
        return sizeof(CargoService::$errosValidacao)==0;
    }

    

}
?>