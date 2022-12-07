<?php 
namespace TheStore\Application\Factories\Product;

use DI\Container;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheStore\Application\UseCases\Product\LoadProduct;
use TheStore\Application\Web\Controllers\Product\LoadProductOperation;
use TheStore\Application\Web\WebController;
use TheStore\Domain\Product\Product;

class MakeLoadProductsController
{
    protected $controller;

    public function __construct(Container $container)
    {
        $productRepository = $container->get("ProductRepository");
        $useCase = new LoadProduct($productRepository);
        $this->controller = new WebController(new LoadProductOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload = $request->getQueryParams();
        $responseController = $this->controller->handle($payload);

        $response->getBody()->write(json_encode($responseController['body']));
        return $response->withHeader("Content-Type", "application/json")->withStatus($responseController['statusCode']);
    }
}