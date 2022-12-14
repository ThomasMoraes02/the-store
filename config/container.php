<?php

use DI\ContainerBuilder;
use TheStore\Application\Authentication\CustomAuthentication;
use TheStore\Infraestructure\Authentication\TokenJWT;
use TheStore\Infraestructure\Product\ProductRepositoryMongo;
use TheStore\Infraestructure\User\EncoderArgonII;
use TheStore\Infraestructure\User\UserRepositoryMongo;

use function DI\create;
use function DI\get;

/**
 * Definindo dependĂȘncias
 */
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    "Encoder" => create(EncoderArgonII::class),
    "UserRepository" => create(UserRepositoryMongo::class),
    "ProductRepository" => create(ProductRepositoryMongo::class),
    "TokenManager" => create(TokenJWT::class),
    "AuthenticationService" => create(CustomAuthentication::class)->constructor(get("UserRepository"),get("Encoder"), get("TokenManager"))
]);

return $containerBuilder->build();