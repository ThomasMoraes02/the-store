<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use TheStore\Application\Factories\User\MakeSignInController;
use TheStore\Application\Factories\User\MakeSignUpController;
use TheStore\Application\Factories\Product\MakeLoadProductsController;
use TheStore\Application\Factories\Product\MakeCreateProductController;
use TheStore\Application\Factories\Product\MakeDeleteProductController;
use TheStore\Application\Factories\Product\MakeUpdateProductController;

require_once("vendor/autoload.php");

$container = require __DIR__ . "../../config/container.php";

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->post("/signup", new MakeSignUpController($container));

$app->post("/signin", new MakeSignInController($container));

$app->group("/products", function(RouteCollectorProxy $group) {
    $group->get("", new MakeLoadProductsController($this));
    $group->get("/{id}", new MakeLoadProductsController($this));
    $group->post("", new MakeCreateProductController($this));
    $group->put("/{id}", new MakeUpdateProductController($this));
    $group->delete("/{id}", new MakeDeleteProductController($this));
});

$app->run();