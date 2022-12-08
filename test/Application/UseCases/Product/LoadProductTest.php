<?php 
namespace TheStore\Tests\Application\UseCases\Product;

use PHPUnit\Framework\TestCase;
use TheStore\Application\UseCases\Product\LoadProduct;
use TheStore\Domain\Product\Product;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\Product\ProductRepositoryMemory;

class LoadProductTest extends TestCase
{
    private ProductRepository $repository;

    protected function setUp(): void
    {
        $product = Product::create("Teste", "100.5", "Product Test", "59", "test");
        $this->repository = new ProductRepositoryMemory;
        $this->repository->addProduct($product);
    }

    public function test_load_product_use_case()
    {
        $loadProduct = new LoadProduct($this->repository);

        $request = [
            "id" => 0
        ];

        $response = $loadProduct->perform($request);

        $this->assertEquals("Teste", $response[0]->getTitle());
    }

    public function test_load_all_products()
    {
        $product1 = Product::create("Teste1", "100.5", "Product Test", "59", "test");
        $product2 = Product::create("Teste2", "100", "Product Test 2", "5", "test");
        $product3 = Product::create("Teste3", "10.5", "Product Test 3", "9", "test 2");

        $this->repository->addProduct($product1);
        $this->repository->addProduct($product2);
        $this->repository->addProduct($product3);

        $products = $this->repository->findAll();
        $this->assertEquals(4, count($products));
    }
}