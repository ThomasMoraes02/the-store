<?php 
namespace TheStore\Infraestructure\Product;

use TheStore\Domain\Product\Category;
use TheStore\Domain\Product\Product;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\Exceptions\ProductNotFound;

class ProductRepositoryMemory implements ProductRepository
{
    private array $products = [];

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function findById(int $id): Product
    {
        $product = $this->findProduct($id);
        return current($product);
    }

    public function findByCategory(Category $category): array
    {
        $products = array_filter($this->products, fn($product) => $product->getCategory() == $category);

        if(empty($products)) {
            throw new ProductNotFound();
        }

        return $products;
    }

    public function updateProduct(int $id, array $data): void
    {
        $product = $this->findProduct($id);
        $product = current($product);

        foreach($data as $key => $value) {
            if(property_exists($product, $key) == true) {
                $set = "set$key";
                $product->$set($value);
            }
        }
    }

    public function deleteProduct(int $id): void
    {
        $this->findProduct($id);
        unset($this->products[$id]);
    }

    public function findAll(int $page = 0, int $limit = 0): array
    {
        return $this->products;
    }

    private function findProduct(int $id): array
    {
        $product = array_filter($this->products, fn($productId) => $id == $productId, ARRAY_FILTER_USE_KEY);

        if(empty($product)) {
            throw new ProductNotFound();
        }

        return $product;
    }
}