<?php
    define("ROOT", __DIR__."/../../");
    define("BASE_URL","http://localhost/crud_ipdv/public/index.php");
    include ROOT."autoload.php";
    include ROOT."vendor/firebase/php-jwt/src/JWT.php";
    include ROOT."vendor/firebase/php-jwt/src/BeforeValidException.php";
    include ROOT."vendor/firebase/php-jwt/src/ExpiredException.php";
    include ROOT."vendor/firebase/php-jwt/src/JWK.php";
    include ROOT."vendor/firebase/php-jwt/src/SignatureInvalidException.php";
    include __DIR__."/../model/service/RegexService.php";
    require __DIR__."/../route/RouteConfig.php";

?>