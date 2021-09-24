<?php 
namespace app\database;
interface IConnection{
    public function connect();
    public function closeConnection($success);
    public function getData($query);
    public function executeQuery($query);
}
?>