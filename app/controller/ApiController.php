<?php

namespace app\controller;

class ApiController{
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($classInstance)
    {        
        $objs = get_class($classInstance)::all();        
        if(sizeof($objs)==0){
            $apiResponse = new ApiResponse(false,"Nenhum registro encontrado!",[],[],404);
        }else{
            $apiResponse = new ApiResponse(true,"",[],$objs,200);
        }
        return $apiResponse->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$rules, $classInstance)
    {
        
        // array_merge($request->all(), ['id_usuario' => JWTAuth::user()->id]);
        //if(UserController::itsMe($request->id_usuario)){
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
              $apiResponse = new ApiResponse(false,"Dados inválidos",$validator->errors(),[],400);
            }else{
                $apiResponse= new ApiResponse(true,"Dados cadastrados com sucesso!",[],get_class($classInstance)::create($request->all()),201);
            }
            return $apiResponse->response();
        /*}
        else{
            $errors=[];
            $errors_id_usuario=[];            
            array_push($errors_id_usuario,"Não é correspondente com o usuário autenticado!");
            $errors["id_usuario"]=$errors_id_usuario;           
            return $this->stopExecution("Não é permitido cadastrar dados na conta de outro usuário!",null,$errors);
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $classInstance,$contexto_usuario = false)
    {
        $object = get_class($classInstance)::find($id);      
        
        if(is_null($object)){
            $apiResponse = new ApiResponse(false,"Registro não encontrado!",[],[],404);
        }else{ 
            if($contexto_usuario){
                if(!UserController::itsMe($object->id_usuario)){
                    return $this->stopExecution("Este registro não pertence ao usuário autenticado!",null,null,403);
                }
            }
            $apiResponse = new ApiResponse(true,"",[],$object->details(),200);
        }
        return $apiResponse->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $rules, $classInstance)
    {
        $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                $apiResponse = new ApiResponse(false,"Dados inválidos",$validator->errors(),[],400);
            }else{ 
                $object = get_class($classInstance)::find($id);//->where('id_usuario',JWTAuth::user()->id);
                if(is_null($object)){
                    $apiResponse = new ApiResponse(false,"Registro não encontrado!",[],[],404);
                }else{            
                if($object->update($request->all())==1){
                        $apiResponse = new ApiResponse(true,"Dados atualizados com sucesso!",[],[],200);
                }
                
                }
            }
        return $apiResponse->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $classInstance)
    {
        $object = get_class($classInstance)::find($id);
        if(is_null($object)){
            $apiResponse = new ApiResponse(false,"Registro não encontrado",[],[],404);
        }else{
            if(get_class($classInstance)::destroy($id) == 1){
                $apiResponse = new ApiResponse(true,"Dados removidos com sucesso!",[],$object,200);
            }
        }
        return $apiResponse->response();  
    }
    
    public function stopExecution($reason,$data=null,$errors=null,$statusCode=500){  
        if(is_null($data)){
            $data = [];
        }      
       $apiResponse = new ApiResponse(false,$reason,(object)$errors,$data,$statusCode);
       return $apiResponse->response();
    }

    public static function handle_put_payload($payload){
        $params = explode("&",$payload);
        $return = array();
        foreach($params as $param){
            $splitParam = explode("=",$param);
            $key = urldecode($splitParam[0]);
            $value=urldecode($splitParam[1]);
            $return[$key] = $value;
        }
        
    }

}