<?php 
namespace TheStore\Application\UseCases\User;

use TheStore\Domain\User\User;
use TheStore\Domain\User\Email;
use TheStore\Domain\User\Encoder;
use TheStore\Domain\User\UserRepository;
use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Exceptions\EmailException;
use TheStore\Application\Exceptions\InvalidPassword;
use TheStore\Infraestructure\Exceptions\UserNotFound;
use TheStore\Application\Authentication\AuthenticationService;

class SignUp implements UseCase
{
    private UserRepository $userRepository;
    private Encoder $encoder;
    private AuthenticationService $authentication;

    public function __construct(UserRepository $userRepository, Encoder $encoder, AuthenticationService $authentication)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        $this->authentication = $authentication;
    }

    public function perform(array $request)
    {
        try {
            $user = $this->userRepository->findByEmail(new Email($request['email']));
            $compare = $this->encoder->decode($request['password'], $user->getPassword());

            if($compare == false) {
                throw new InvalidPassword;
            }
        } catch(UserNotFound | InvalidPassword $e) {
            $user = User::create($request['name'], $request['cpf'], $request['email'], $request['phone'], $request['address'], new $this->encoder);
            $user->setPassword($request['password']);
            $this->userRepository->addUser($user);
        }

        $response = $this->authentication->auth([
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "password" => $request['password']
        ]);

        return $response;
    }
}