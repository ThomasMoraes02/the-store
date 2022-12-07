<?php 
namespace TheStore\Tests\Application\UseCases\Product;

use PHPUnit\Framework\TestCase;
use TheStore\Application\UseCases\Product\CreateProduct;
use TheStore\Domain\Product\Product;
use TheStore\Infraestructure\Product\ProductRepositoryMemory;

class CreateProductTest extends TestCase
{
    public function test_create_product_use_case()
    {
        $repository = new ProductRepositoryMemory;
        $createProduct = new CreateProduct($repository);

        $request = [
            "title" => "Test",
            "price" => "110.5",
            "description" => "This is a product",
            "amount" => "6",
            "category" => "Test Category"
        ];

        $createProduct->perform($request);

        $product = $repository->findAll();
        $this->assertEquals(110.5, $product[0]->getPrice());
        $this->assertEquals(6, $product[0]->getAmount());
        $this->assertEquals("Test Category", $product[0]->getCategory());
    }
}