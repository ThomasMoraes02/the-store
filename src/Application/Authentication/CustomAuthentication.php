<?php 
namespace TheStore\Application\Authentication;

use TheStore\Domain\User\Encoder;
use TheStore\Domain\User\UserRepository;
use TheStore\Application\Exceptions\InvalidPassword;
use TheStore\Application\Authentication\TokenManager;

class CustomAuthentication implements AuthenticationService
{
    private UserRepository $userRepository;
    private Encoder $encoder;
    private TokenManager $tokenManager;

    public function __construct(UserRepository $userRepository, Encoder $encoder, TokenManager $tokenManager)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        $this->tokenManager = $tokenManager;
    }

    public function auth(array $authenticationParams): array
    {
        $user = $this->userRepository->findByEmail($authenticationParams['email']);
        $compare = $this->encoder->decode($authenticationParams['password'], $user->getPassword());

        if($compare == false) {
            throw new InvalidPassword();
        }

        $accessToken = $this->tokenManager->signIn(["email" => strval($user->getEmail()), "name" => $user->getName()]);

        return [
            "accessToken" => $accessToken,
            "email" => strval($user->getEmail())
        ];
    }
}