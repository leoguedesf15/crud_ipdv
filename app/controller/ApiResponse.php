<?php

namespace app\controller;

use JsonSerializable;

class ApiResponse implements JsonSerializable
{
    private $success;
    private $message;
    private $errors;
    private $data;

    public function __construct($blnSuccess,$strMessage,$arrErrors,$arrData,$intStatusCode){
        $this->success = $blnSuccess;
        $this->message = $strMessage;
        $this->errors = $arrErrors;
        $this->data = $arrData;
        http_response_code($intStatusCode);        
    }

    public function response(){        
        $resposta = $this->jsonSerialize();
        echo json_encode($resposta);
        die();
    }
    function jsonSerialize(){
        return get_object_vars($this);
    }
  
}