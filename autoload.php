<?php   
    spl_autoload_register(
        function($classes){
            require __DIR__."/".$classes.".php";
        }
    );
?>