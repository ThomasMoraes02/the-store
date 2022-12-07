<?php 
namespace TheStore\Domain\User;

interface Encoder
{
    public function encode(string $password): string;

    public function decode(string $password, string $passwordEncode): bool;
}