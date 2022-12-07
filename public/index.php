<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use TheStore\Application\Factories\Product\MakeLoadProductsController;
use TheStore\Application\Factories\Product\MakeCreateProductController;

require_once("vendor/autoload.php");

$container = require __DIR__ . "../../config/container.php";


AppFactory::setContainer($container);
$app = AppFactory::create();

$app->group("/products", function(RouteCollectorProxy $group) {
    $group->get("", new MakeLoadProductsController($this));
    $group->get("/{id}", new MakeLoadProductsController($this));
    $group->post("", new MakeCreateProductController($this));
});

$app->run();