<?php 
namespace TheStore\Application\UseCases;

interface UseCase
{
    public function perform(array $request);
}