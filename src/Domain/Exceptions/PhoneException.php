<?php 
namespace TheStore\Domain\Exceptions;

use DomainException;

class PhoneException extends DomainException
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}