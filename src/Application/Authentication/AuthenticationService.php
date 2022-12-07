<?php 
namespace TheStore\Application\Authentication;

interface AuthenticationService
{
    public function auth(array $authenticationParams): array;
}