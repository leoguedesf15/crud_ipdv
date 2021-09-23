<?php
namespace app\controller;
class BaseController{
    public function __call($actionName,$options){
        return call_user_func_array($actionName,$options);  
    }
}
?>