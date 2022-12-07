<?php 
namespace TheStore\Application\Middleware;

interface Middleware
{
    public function handle(string $request);
}