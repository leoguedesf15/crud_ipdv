<?php
namespace app\controller;

use app\model\service\JWTTokenService;
use app\controller\ApiResponse;
class AuthController{
    private $admin=[
                        "email"=>"admin@admin",
                        "senha"=>"202cb962ac59075b964b07152d234b70"
    ];

    //a senha corresponde ao hash md5 de "123" o front envia a senha encriptada e é feita 
    //a comparação com o hash salvo no banco
    public function login(){        
        if($_POST["email"] == $this->admin["email"]  && $_POST["senha"]==$this->admin["senha"]){
            $token = JWTTokenService::generate();            
            $apiResponse = new ApiResponse(true,"Login Efetuado com sucesso!",null,["token"=>$token],200);
            $apiResponse->response();
        }
        else{
            $apiController = new ApiController();
            $apiController->stopExecution("Email ou senha incorretos!",null,null,401);
        }
    }
    public function verificarToken($token){
        return JWTTokenService::verify($token);
    }
    public function endPointValidacaoToken(){
        if($this->verificarToken($_POST["token"])){
            $apiResponse = new ApiResponse(true,"Autorizado!",[],[],200);
        }else{
            $apiResponse = new ApiResponse(false,"Usuário não autorizado!",[],[],401);            
        }
        $apiResponse->response();
    }
    
}
?>