<?php 
namespace TheStore\Tests\Application\UseCases\User;

use TheStore\Domain\User\User;
use PHPUnit\Framework\TestCase;
use TheStore\Application\Authentication\CustomAuthentication;
use TheStore\Domain\User\Encoder;
use TheStore\Domain\User\UserRepository;
use TheStore\Infraestructure\User\EncoderArgonII;
use TheStore\Application\Authentication\TokenManager;
use TheStore\Application\UseCases\User\SignUp;
use TheStore\Infraestructure\Authentication\TokenJWT;
use TheStore\Infraestructure\User\UserRepositoryMemory;

class SignUpTest extends TestCase
{
    private UserRepository $userRepository;
    private TokenManager $tokenManager;
    private Encoder $encoder;

    protected function setUp(): void
    {
        $this->encoder = new EncoderArgonII;
        $this->tokenManager = new TokenJWT;

        $user = User::create("Thomas", "123.456.789-09", "thomas@gmail.com", ["11", "965813697"], ["08753650", "city", "street", "1"], $this->encoder);
        $user->setPassword("123456");

        $this->userRepository = new UserRepositoryMemory;
        $this->userRepository->addUser($user);
    }

    public function test_sign_up_use_case()
    {
        $signUp = new SignUp($this->userRepository, $this->encoder, new CustomAuthentication($this->userRepository, $this->encoder, $this->tokenManager));

        $request = [
            "name" => "teste",
            "cpf" => "123.456.789-09",
            "email" => "teste@gmail.com",
            "phone" => ["11", "987456321"],
            "address" => ["06548259", "citys", "streets", "36"],
            "password" => "987654"
        ];

        $response = $signUp->perform($request);
        $this->assertEquals("teste@gmail.com", $response['email']);
        
        $allUsers = $this->userRepository->findAll();
        $this->assertEquals(2, count($allUsers));
    }
}