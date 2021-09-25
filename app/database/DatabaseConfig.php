<?php 
namespace app\database;

class DatabaseConfig implements IConfig{
    //DatabaseConfig implementa IConfig pois
    //Se tivessemos mais de uma conexão a dados, cada Conexão teria suas configurações
    private $data =[
        'host'=>'localhost',
        'username'=>'postgres',
        'password'=>'123456',
        'database'=>'crud_ipdv_leonardo',
        'driver'=>'pgsql',
        'port'=>'5432'
    ];

    public function get($key){
        return $this->data[$key];
    }
}
?>