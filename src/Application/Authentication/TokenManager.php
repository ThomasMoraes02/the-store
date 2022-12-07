<?php 
namespace TheStore\Application\Authentication;

interface TokenManager
{
    public function signIn($payload, $expires = null): string;

    public function verify(string $token): bool;
}