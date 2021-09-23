<?php   
    spl_autoload_register(
        function($classes){
            require ROOT.$classes.".php";
        }
    );
?>