<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\UsuarioDAO;
use app\model\service\IService;
class UsuarioService implements IService{
    public static function all(){        
       $dao = new UsuarioDAO(new DatabaseConnection());
       var_dump($dao->selectAll()->get()); 
    }
}
?>