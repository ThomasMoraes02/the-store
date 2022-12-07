<?php 
namespace TheStore\Infraestructure\Authentication;

use DateTime;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use TheStore\Application\Authentication\TokenManager;

class TokenJWT implements TokenManager
{
    private string $key;

    private int $expirationTime;

    public function __construct()
    {
        $this->key = "this-is-my-key-test";
        $this->expirationTime = time() + 60 * 60 * 24 * 5;
    }

    public function encode($payload): string
    {
        $payloadJwt = [
            "iss" => $this->key,
            "exp" => $this->expirationTime,
            "name" => $payload['name'],
            "role" => "user"
        ];

        return JWT::encode($payloadJwt, $this->key, 'HS256');
    }

    public function decode(string $token): bool
    {
        $decode = JWT::decode($token, new Key($this->key, 'HS256'));

        $expires = new DateTime(date('Y-m-d',$decode->exp));
        $interval = $expires->diff(new DateTime());

        if($interval->days > 5) {
            return false;
        }
        return true;
    }
}