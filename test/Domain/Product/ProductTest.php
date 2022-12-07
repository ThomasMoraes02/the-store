<?php 
namespace TheStore\Tests\Domain\Product;

use PHPUnit\Framework\TestCase;
use TheStore\Domain\Product\Category;
use TheStore\Domain\Product\Product;

class ProductTest extends TestCase
{
    public function test_create_product()
    {
        $product = new Product("Jacket", 55.5, "Slim-fitting style", 10, new Category("men's clothing"));
        $this->assertEquals($product->getTitle(), "Jacket");
        $this->assertEquals(10, $product->getAmount());

        $product2 = Product::create("Test", "100.5", "Test Test", "5", "men's clothing");
        $this->assertEquals($product2->getTitle(), "Test");
        $this->assertEquals($product2->getPrice(), 100.5);
        $this->assertEquals($product2->getAmount(), 5);
        $this->assertEquals($product2->getCategory(), "men's clothing");
    }
}