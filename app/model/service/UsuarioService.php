<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
use app\model\dao\CargoDAO;
use app\model\dao\DepartamentoDAO;

class UsuarioService implements IService{
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
        $users = $dao->selectAll()->where(" id_usuario=".$id)->get();
        $user = $users[0];           
        $cargo = $cargoDAO->selectAll()->where(" id_cargo=".$user["id_cargo_fk"])->get();
        $departamento = $departamentoDAO->selectAll()->where(" id_departamento=".$user["id_departamento_fk"])->get();
        $user["cargo"] = $cargo[0];
        $user["departamento"] = $departamento[0];
        $users[0]=$user;
        return $users;
    }

}
?>