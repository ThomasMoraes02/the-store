<?php 
namespace TheStore\Domain\Product;

class Category
{
    private string $category;

    public function __construct(string $category)
    {
        $this->category = $category;
    }

    public function __toString(): string
    {
        return $this->category;
    }
}