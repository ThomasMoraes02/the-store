<?php 
namespace TheStore\Application\Factories\Product;

use DI\Container;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheStore\Application\Web\WebController;
use TheStore\Application\UseCases\Product\DeleteProduct;
use TheStore\Application\Web\Controllers\Product\DeleteProductOperation;

class MakeDeleteProductController
{
    protected $controller;

    public function __construct(Container $container)
    {
        $productRepository = $container->get("ProductRepository");
        $useCase = new DeleteProduct($productRepository);
        $this->controller = new WebController(new DeleteProductOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload['id'] = $args['id'];

        $responseController = $this->controller->handle($payload);

        $response->getBody()->write(json_encode($responseController['body']));
        return $response->withHeader("Content-Type", "application/json")->withStatus($responseController['statusCode']);
    }
}