<?php 
namespace TheStore\Tests\Infraestructure\Product;

use PHPUnit\Framework\TestCase;
use TheStore\Domain\Product\Category;
use TheStore\Domain\Product\Product;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\Exceptions\ProductNotFound;
use TheStore\Infraestructure\Product\ProductRepositoryMemory;

class ProductRepositoryMemoryTest extends TestCase
{
    private Product $product;
    private ProductRepository $repository;

    protected function setUp(): void
    {
        $this->product = Product::create("Test", "250.5", "This is a Product Test", "67", "Mens Clothing");
        $this->repository = new ProductRepositoryMemory;
        $this->repository->addProduct($this->product);
    }

    public function test_add_product()
    {
        $this->assertNotEmpty($this->repository);
    }

    public function test_find_by_id()
    {
        $product = $this->repository->findById(0);
        $this->assertEquals("Test", $product->getTitle());
    }

    public function test_find_by_category()
    {
        $product = Product::create("Test2", "25", "This is a Product Test2", "7", "Mens Clothing");
        $this->repository->addProduct($product);
        
        $products = $this->repository->findByCategory(new Category("Mens Clothing"));
        $this->assertEquals(2, count($products));
    }

    public function test_delete_product()
    {
        $this->expectException(ProductNotFound::class);
        $product = Product::create("Test2", "25", "This is a Product Test2", "7", "Mens Clothing");
        $this->repository->addProduct($product);

        $this->repository->deleteProduct(1);
        $this->repository->findById(1);
    }

    public function test_update_product()
    {
        $data = [
            "title" => "New Title Product",
            "price" => "55.5",
            "amount" => "26"
        ];

        $this->repository->updateProduct(0, $data);
        $product = $this->repository->findById(0);
        
        $this->assertEquals("New Title Product", $product->getTitle());
        $this->assertEquals(55.5, $product->getPrice());
        $this->assertEquals(26, $product->getAmount());
    }
}