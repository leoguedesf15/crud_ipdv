<?php

namespace app\controller;

class ApiController{
    //A camada controller da minha aplicação serve apenas para instanciar o serviço necessário para
    //buscar a informação e efetuar as validações necessárias. Serve também para delegar responsabilidades
    //a fim de obter os dados necessários.

    public function index($classInstance)
    {   
        $this->verificarAutenticacao();
        //injetando dependência pra trabalhar inversão de controle (caso o serviço precise estourar uma exceção)
        $classInstance->controller = $this;     
        $objs = $classInstance->all();    
        if(sizeof($objs)==0){
            $apiResponse = new ApiResponse(false,"Nenhum registro encontrado!",[],[],404);
        }else{
            $apiResponse = new ApiResponse(true,"",[],$objs,200);
        } 
        $apiResponse->response();
    }

    public function store($body,$classInstance){
        $this->verificarAutenticacao();
          //injetando dependência pra trabalhar inversão de controle (caso o serviço precise estourar uma exceção)
          $classInstance->controller = $this;  
          $apiResponse= new ApiResponse(true,"Dados cadastrados com sucesso!",[],$classInstance->create($body),201);            
          $apiResponse->response();
     }

    public function show($id, $classInstance)
    {
        $this->verificarAutenticacao();
        //injetando dependência pra trabalhar inversão de controle (caso o serviço precise estourar uma exceção)
        $classInstance->controller = $this;
        $object = $classInstance->find($id);      
        
        if(is_null($object)){
            $apiResponse = new ApiResponse(false,"Registro não encontrado!",[],[],404);
        }else{          
            $apiResponse = new ApiResponse(true,"",[],$object,200);
        }
        $apiResponse->response();
    }
    
    public function update($id, $classInstance)
    {    
        $this->verificarAutenticacao();
        //injetando dependência pra trabalhar inversão de controle (caso o serviço precise estourar uma exceção)
        $classInstance->controller = $this;
        $body=file_get_contents('php://input');        
        $payload = $this->handle_put_payload($body);
        if($payload == null){
            $this->stopExecution("Parâmetros inválidos",[],["Nenhum parâmetro enviado"],400);
        } 
        $object = $classInstance->find($id);
        if(is_null($object)){
            $apiResponse = new ApiResponse(false,"Registro não encontrado!",[],[],404);
        }else{            
            if($classInstance->update($id,$payload)==1){
                    $apiResponse = new ApiResponse(true,"Dados atualizados com sucesso!",[],[],200);
            }
        }
        $apiResponse->response();
    }

    public function destroy($id, $classInstance)
    {
        $this->verificarAutenticacao();
        //injetando dependência pra trabalhar inversão de controle (caso o serviço precise estourar uma exceção)
        $classInstance->controller = $this;
        $object = $classInstance->find($id);        
        if(is_null($object)){
            $apiResponse = new ApiResponse(false,"Registro não encontrado",[],[],404);
        }else{
            if($classInstance->destroy($id) == 1){
                $apiResponse = new ApiResponse(true,"Dados removidos com sucesso!",[],$object,200);
            }
        }
        $apiResponse->response();  
    }
    
    public function stopExecution($reason,$data=null,$errors=null,$statusCode=500){  
        if(is_null($data)){
            $data = [];
        }      
       $apiResponse = new ApiResponse(false,$reason,$errors,$data,$statusCode);
       $apiResponse->response();
    }

    private function handle_put_payload($payload){
        $params = explode("&",$payload);

        $return = array();

        if(sizeof($params)>0 && $params[0]!=""){
            foreach($params as $param){
                $splitParam = explode("=",$param);
                $key = urldecode($splitParam[0]);            
                $value=urldecode($splitParam[1]);
                $return[$key] = $value;
            }
        }else{
            return null;
        }
        return $return;
    }

    private function verificarAutenticacao(){
        $headers = apache_request_headers();
        $auth = new AuthController();
        if(isset($headers["Authorization"]) && $auth->verificarToken(substr($headers["Authorization"],7))){
            return ;
        }
        $this->stopExecution("Não autorizado!",null,null,401);
    }

}