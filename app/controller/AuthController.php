<?php
namespace app\controller;

use app\model\service\JWTTokenService;
use app\controller\ApiResponse;
class AuthController{
    
    public function login(){
        if($_POST["email"] == "admin@admin" && $_POST["senha"]="123"){
            $token = JWTTokenService::generate();            
            $apiResponse = new ApiResponse(true,"Login Efetuado com sucesso!",null,["token"=>$token],200);
            $apiResponse->response();
        }
        else{
            $apiController = new ApiController();
            $apiController->stopExecution("Email ou senha incorretos autorizado!",null,null,401);
        }
    }
    public static function verificarToken($token){
        return JWTTokenService::verify($token);
    }
}
?>