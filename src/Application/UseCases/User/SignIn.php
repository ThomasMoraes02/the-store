<?php 
namespace TheStore\Application\UseCases\User;

use TheStore\Application\Authentication\AuthenticationService;
use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\User\Email;

class SignIn implements UseCase
{
    private AuthenticationService $authentication;

    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    public function perform(array $request)
    {
        $response = $this->authentication->auth([
            "email" => new Email($request['email']),
            "password" => $request['password']
        ]);

        return $response;
    }
}