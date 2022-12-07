<?php 
namespace TheStore\Application\Authentication;

interface TokenManager
{
    public function encode(array $payload): string;

    public function decode(string $token): bool;
}