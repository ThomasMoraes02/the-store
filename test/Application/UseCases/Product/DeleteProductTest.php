<?php 
namespace TheStore\Tests\Application\UseCases\Product;

use PHPUnit\Framework\TestCase;
use TheStore\Application\UseCases\Product\DeleteProduct;
use TheStore\Domain\Product\Category;
use TheStore\Domain\Product\Product;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\Exceptions\ProductNotFound;
use TheStore\Infraestructure\Product\ProductRepositoryMemory;

class DeleteProductTest extends TestCase
{
    private ProductRepository $repository;

    protected function setUp(): void
    {
        $product = new Product("Test", 11.4, "Test Description", 9, new Category("Category Test"));
        $this->repository = new ProductRepositoryMemory;
        $this->repository->addProduct($product);   
    }

    public function test_delete_product_use_case()
    {
        $deleteProduct = new DeleteProduct($this->repository);

        $request = [
            "id" => 0
        ];

        $deleteProduct->perform($request);

        $products = $this->repository->findAll();
        $this->assertEmpty($products);
    }

    public function test_delete_product_not_exists()
    {
        $this->expectException(ProductNotFound::class);

        $deleteProduct = new DeleteProduct($this->repository);

        $request = [
            "id" => 1
        ];

        $deleteProduct->perform($request);
    }
}