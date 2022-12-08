<?php 
namespace TheStore\Application\Factories\Product;

use DI\Container;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheStore\Application\Web\WebController;
use TheStore\Application\UseCases\Product\UpdateProduct;
use TheStore\Application\Web\Controllers\Product\UpdateProductOperation;

class MakeUpdateProductController
{
    protected $controller;

    public function __construct(Container $container)
    {
        $productRepository = $container->get("ProductRepository");
        $useCase = new UpdateProduct($productRepository);
        $this->controller = new WebController(new UpdateProductOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload = json_decode($request->getBody(),true);
        $payload['id'] = $args['id'];

        $responseController = $this->controller->handle($payload);

        $response->getBody()->write(json_encode($responseController['body']));
        return $response->withHeader("Content-Type", "application/json")->withStatus($responseController['statusCode']);
    }
}