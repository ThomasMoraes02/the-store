<?php 

define("JWT_SECRET_TOKEN", "my-secret-token-jwt-the-store");

define("JWT_EXPIRATION_TOKEN", 5);

define("DB_DRIVER", "mongodb");

define("DB_DATABASE", "thestore");

if(!empty($_SERVER['SERVER_NAME'])) {
    define("SERVER_PROTOCOL", $_SERVER['SERVER_NAME'] == "localhost" ? "http://" : "https://");

    define("SERVER_PORT", $_SERVER['SERVER_PORT']);

    define("SERVER_NAME", $_SERVER['SERVER_NAME']);
}

ini_set('display_errors', 1);