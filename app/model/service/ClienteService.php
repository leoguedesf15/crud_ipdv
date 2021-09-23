<?php
namespace app\model\service;

use app\database\DatabaseConnection;
use app\model\dao\ClienteDAO;
use app\model\service\IService;
class ClienteService implements IService{
    public static function all(){        
       $dao = new ClienteDAO(new DatabaseConnection());
       $dao->selectAll()->get(); 
    }
}
?>