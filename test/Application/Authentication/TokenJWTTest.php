<?php 
namespace TheStore\Tests\Application\Authentication;

use PHPUnit\Framework\TestCase;
use TheStore\Infraestructure\Authentication\TokenJWT;

class TokenJWTTest extends TestCase
{
    public function test_create_token_jwt()
    {
        $tokenManager = new TokenJWT;
        $token = $tokenManager->encode(["name" => "thomas moraes"]);
        $this->assertNotEmpty($token);
    }

    public function test_decode_token_jwt()
    {
        $tokenManager = new TokenJWT;
        $token = $tokenManager->encode(["name" => "thomas moraes"]);

        $decode = $tokenManager->decode($token);
        $this->assertTrue($decode);
    }
}