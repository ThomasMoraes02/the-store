<?php 
namespace TheStore\Domain\Exceptions;

use DomainException;

class CpfException extends DomainException
{
    public function __construct(string $cpf)
    {
        parent::__construct("This CPF is invalid: $cpf");
    }
}