<?php 
namespace app\database;
use PDO;

class DatabaseConnection extends PDO {
    private IConfig $config;
    private $transaction;
    function __construct(){
        $this->config = new DatabaseConfig();
        $connectionString = $this->config->get('driver')
                            .":host=".$this->config->get("host")
                            .";port=".$this->config->get('port')
                            .";dbname=".$this->config->get('database')
                            .";user=".$this->config->get('database')
                            .";password=".$this->config->get('password');
        parent::__construct($connectionString,$this->config->get('username'),$this->config->get('password')); 
    }
    
   
    

}