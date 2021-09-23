<?php 
namespace app\database;
use PDO;
class DatabaseConnection extends PDO implements IConnection {
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
    
    //Interface Overrides
    public function connect(){
        
    }
    public function closeConnection($success){
        if($success){
            $this->commit();
        }else{
           $this->rollBack();
        }
    }
    public function printHello(){
            return 'hello!';
    }


}