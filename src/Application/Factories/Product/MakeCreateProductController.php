<?php 
namespace TheStore\Application\Factories\Product;

use DI\Container;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheStore\Application\UseCases\Product\CreateProduct;
use TheStore\Application\Web\Controllers\Product\CreateProductOperation;
use TheStore\Application\Web\WebController;

class MakeCreateProductController
{
    protected $controller;

    public function __construct(Container $container)
    {
        $productRepository = $container->get("ProductRepository");
        $useCase = new CreateProduct($productRepository);
        $this->controller = new WebController(new CreateProductOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload = json_decode($request->getBody(),true);
        $responseController = $this->controller->handle($payload);

        $response->getBody()->write(json_encode($responseController['body']));
        return $response->withHeader("Content-Type", "application/json")->withStatus($responseController['statusCode']);
    }
}