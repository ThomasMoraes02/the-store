<?php 
namespace TheStore\Application\Exceptions;

use DomainException;

class InvalidPassword extends DomainException
{
    public function __construct()
    {
        parent::__construct("Invalid Password");
    }
}