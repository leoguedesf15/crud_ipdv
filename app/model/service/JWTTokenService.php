<?php
namespace app\model\service;

use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use Firebase\JWT\JWT;
class JWTTokenService{
    private static $key= "pudimcommelancia"; 
    static function generate(){
        //usando firebase para geração e verificação do token
        $header =   [
                        'alg'=>'HS256',
                        'typ'=>'JWT'
                    ];
                    
        $payload =  [
                        'exp'=>JWTTokenService::calcularIntervalo(),
                        'uid'=>1,
                        'email'=>'admin@admin'
                    ];
        
        $output = JWT::encode($payload,JWTTokenService::$key,'HS256',NULL,$header);
        return $output;             
    }

    public static function verify($token){
        JWT::$leeway = 60; // $leeway - em caso de "clock skew"(assincronia dos relógios digitais) essa
                            //variável cede 60 segundos a mais no tempo de expiração do token;
        //Verificação de token junto ao Firebase
        //segundo o código da classe, ela lança uma exceção caso a validação falhe.
        //por isso capturei com try catch para tratar a lógica de negócio
        //
        try{
            JWT::decode($token, JWTTokenService::$key, array('HS256'));
            return true;
        }catch(Exception $ex){
            return false;
        }
    
    }
    private static function calcularIntervalo(){
        //calculo o intervalo de 60 minutos conforme estipulado em regra de negócio e converto pra timestamp
        $data = new DateTime('now',new DateTimeZone("America/Sao_Paulo"));
        $intervalo = date_interval_create_from_date_string('60 minutes');
        $novaData = date_add($data,$intervalo);
        return date_timestamp_get($novaData);
    }
}

?>
