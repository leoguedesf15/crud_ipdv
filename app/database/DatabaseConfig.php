<?php 
namespace app\database;

class DatabaseConfig implements IConfig{
    private $data =[
        'host'=>'localhost',
        'username'=>'crud_ipdv',
        'password'=>'crud1234',
        'database'=>'crud_ipdv',
        'driver'=>'pgsql',
        'port'=>'5432'
    ];

    public function get($key){
        return $this->data[$key];
    }
}
?>