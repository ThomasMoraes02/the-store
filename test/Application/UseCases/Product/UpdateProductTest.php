<?php 
namespace TheStore\Tests\Application\UseCases\Product;

use PHPUnit\Framework\TestCase;
use TheStore\Application\UseCases\Product\UpdateProduct;
use TheStore\Domain\Product\Product;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\Product\ProductRepositoryMemory;

class UpdateProductTest extends TestCase
{
    private ProductRepository $repository;

    protected function setUp():void
    {
        $this->repository = new ProductRepositoryMemory;
        $product = Product::create("Test", "100", "teste description", "5", "test category");
        $this->repository->addProduct($product);
    }

    public function test_update_product_use_case()
    {
        $updateProduct = new UpdateProduct($this->repository);

        $request = [
            "id" => 0,
            "title" => "new title",
            "amount" => 9,
            "category" => "new test category"
        ];

        $response = $updateProduct->perform($request);
        $this->assertEquals("new title", $response->getTitle());
        $this->assertEquals("new test category", $response->getCategory());
    }
}