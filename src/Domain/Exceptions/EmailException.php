<?php 
namespace TheStore\Domain\Exceptions;

use DomainException;

class EmailException extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct("This e-mail is invalid: $email");
    }
}