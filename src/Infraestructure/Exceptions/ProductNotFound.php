<?php 
namespace TheStore\Infraestructure\Exceptions;

use DomainException;

class ProductNotFound extends DomainException
{
    public function __construct()
    {
        parent::__construct("Product not found");
    }
}