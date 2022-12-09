<?php 
namespace TheStore\Application\Factories\User;

use DI\Container;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheStore\Application\UseCases\User\SignIn;
use TheStore\Application\Web\WebController;
use TheStore\Application\Web\Controllers\User\SignInOperation;

class MakeSignInController
{
    protected $controller;

    public function __construct(Container $container)
    {
        $authentication = $container->get("AuthenticationService");

        $useCase = new SignIn($authentication);
        $this->controller = new WebController(new SignInOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload = json_decode($request->getBody(),true);
        $responseController = $this->controller->handle($payload);

        $response->getBody()->write(json_encode($responseController['body']));
        return $response->withHeader("Content-Type", "application/json")->withStatus($responseController['statusCode']);
    }
}