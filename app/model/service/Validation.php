<?php
namespace app\model\service;
class Validation{

    public function validate($value,$validations){

        $vals=explode("|",$validations);
        $return=true;

        foreach($vals as $validation){                    
            $arr = explode(":",$validation);
            $validation_name=$arr[0];
            if(isset($arr[1])){
                if(!$this->$validation_name($value,$arr[1])){
                    $return=false;
                }
            }else{
                if(!$this->$validation_name($value)){
                    $return=false;
                }
            }
        }
        return $return;
    }    
    public function required($value){      
        return isset($value) && $value!="";
    }
    public function length($value,$param){
        return strlen($value)<=$param;
    }
    public function email($value){
        return preg_match(__EMAIL_PATTERN__,$value);
    }
    public function date($value){
        return preg_match(__DATE_PATTERN__,$value);
    }

}
?>