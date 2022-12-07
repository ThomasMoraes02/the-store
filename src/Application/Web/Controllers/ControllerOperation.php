<?php 
namespace TheStore\Application\Web\Controllers;

interface ControllerOperation
{
    public function execute(array $request);
}