<?php

use DI\ContainerBuilder;
use TheStore\Application\Authentication\CustomAuthentication;
use TheStore\Infraestructure\Authentication\TokenJWT;
use TheStore\Infraestructure\Product\ProductRepositoryMongo;
use TheStore\Infraestructure\User\EncoderArgonII;
use TheStore\Infraestructure\User\UserRepositoryMemory;

use function DI\create;

/**
 * Definindo dependências
 */
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    "Encoder" => create(EncoderArgonII::class),
    "UserRepository" => create(UserRepositoryMemory::class),
    "ProductRepository" => create(ProductRepositoryMongo::class),
    "TokenManager" => create(TokenJWT::class),
    "AuthenticationService" => create(CustomAuthentication::class)->constructor(UserRepositoryMemory::class, EncoderArgonII::class, TokenJWT::class)
]);

return $containerBuilder->build();