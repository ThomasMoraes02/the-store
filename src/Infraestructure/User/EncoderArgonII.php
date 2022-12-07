<?php 
namespace TheStore\Infraestructure\User;

use TheStore\Domain\User\Encoder;

class EncoderArgonII implements Encoder
{
    public function encode(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    public function decode(string $password, string $passwordEncode): bool
    {
        return password_verify($password, $passwordEncode);
    }
}