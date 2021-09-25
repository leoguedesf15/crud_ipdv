<?php

namespace app\controller;

class ApiController{
    
    public function index($classInstance)
    {   
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
          //injetando dependência pra trabalhar inversão de controle (caso o serviço precise estourar uma exceção)
          $classInstance->controller = $this;  
          $apiResponse= new ApiResponse(true,"Dados cadastrados com sucesso!",[],$classInstance->create($body),201);            
          $apiResponse->response();
     }

    public function show($id, $classInstance)
    {
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
        //injetando dependência pra trabalhar inversão de controle (caso o serviço precise estourar uma exceção)
        $classInstance->controller = $this;
        $body=file_get_contents('php://input');        
        $payload = $this->handle_put_payload($body);
        if($payload == null){
            $this->stopExecution("Parâmetros inválidos",[],["Nenhum parâmetro enviado"],400);
        } 
        $object = $classInstance->find($id);//->where('id_usuario',JWTAuth::user()->id);
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

    public function handle_put_payload($payload){
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

}