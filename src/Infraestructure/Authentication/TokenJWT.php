<?php 
namespace TheStore\Infraestructure\Authentication;

use DateTime;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use TheStore\Application\Authentication\TokenManager;

class TokenJWT implements TokenManager
{
    public function encode($payload): string
    {
        $expires = time() + 60 * 60 * 24 * JWT_EXPIRATION_TOKEN;

        $payloadJwt = [
            "iss" => JWT_SECRET_TOKEN,
            "exp" => $expires,
            "name" => $payload['name'],
            "role" => "user"
        ];

        return JWT::encode($payloadJwt, JWT_SECRET_TOKEN, 'HS256');
    }

    public function decode(string $token): bool
    {
        $decode = JWT::decode($token, new Key(JWT_SECRET_TOKEN, 'HS256'));

        $expires = new DateTime(date('Y-m-d',$decode->exp));
        $interval = $expires->diff(new DateTime());

        if($interval->days > JWT_EXPIRATION_TOKEN) {
            return false;
        }
        return true;
    }
}