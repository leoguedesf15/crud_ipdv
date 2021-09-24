<?php
namespace app\model\service;
class Validation{

    public function validate($value,$validations){
        $vals=explode("|",$validations);
        
        foreach($vals as $validation){   
            echo $validation;        
            $arr = explode(":",$validation);
            $validation_name=$arr[0];
            var_dump($validation_name);
            if(isset($arr[1])){
                return $this->$validation_name($value,$arr[1]);
            }else{
                return $this->$validation_name($value);
            }
        }
    }    
    public function required($value){      
        return isset($value) && $value!="";
    }
    public function length($value,$param){
        return strlen($value)<=$param;
    }

}
?>