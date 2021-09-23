<?php

namespace app\controller;

class ApiResponse
{
    private $success;
    private $message;
    private $errors;
    private $data;
    private $statuscode;

    public function __construct($blnSuccess,$strMessage,$arrErrors,$arrData,$intStatusCode){
        $this->success = $blnSuccess;
        $this->message = $strMessage;
        $this->errors = $arrErrors;
        $this->data = $arrData;
        $this->statusCode = $intStatusCode;
    }

    public function response(){
        $response = new StdClass();
        $response->message=$this->message;
        $response->success=$this->success; 
        $response->errors=$this->errors;
        $response->data=$this->data;
        http_response_code($this->statuscode);
        return json_encode($response);
    }
}