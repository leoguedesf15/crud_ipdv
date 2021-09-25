<?php 
namespace app\database;
use PDO;

class DatabaseConnection extends PDO {
    //Database Connection extende PDO, instancia a conexão com o banco, gerencia as transações a mando da camada DAO,
    //buscando as informações necessárias para a conexão através de uma instância de alguma classe
    //que implemente IConfig;
    //Se tivéssemos N conexões, cada 1 possuiria sua própria instância de IConfig;
    //Uma adaptação do padrão de projetos Strategy; 
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