<?php 
namespace TheStore\Tests\Application\UseCases\User;

use PHPUnit\Framework\TestCase;
use TheStore\Application\Authentication\CustomAuthentication;
use TheStore\Application\UseCases\User\SignIn;
use TheStore\Domain\User\Encoder;
use TheStore\Domain\User\User;
use TheStore\Domain\User\UserRepository;
use TheStore\Infraestructure\Authentication\TokenJWT;
use TheStore\Infraestructure\User\EncoderArgonII;
use TheStore\Infraestructure\User\UserRepositoryMemory;

class SignInTest extends TestCase
{
    private UserRepository $repository;
    private Encoder $encoder;
    private User $user;

    protected function setUp(): void
    {
        $this->encoder = new EncoderArgonII;
        $this->user = User::create("Thomas", "123.456.789-09", "thomas@gmail.com", ["11", "965813697"], ["08753650", "city", "street", "1"], $this->encoder);
        $this->user->setPassword("123456");

        $this->repository = new UserRepositoryMemory;
        $this->repository->addUser($this->user);
    }

    public function test_use_case_signin()
    {
        $signIn = new SignIn(new CustomAuthentication($this->repository, $this->encoder, new TokenJWT));

        $request = [
            "email" => "thomas@gmail.com",
            "password" => "123456"
        ];

        $response = $signIn->perform($request);
        $this->assertEquals("thomas@gmail.com", $response['email']);
    }
}