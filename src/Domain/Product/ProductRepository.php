<?php 
namespace TheStore\Domain\Product;

interface ProductRepository
{
    public function addProduct(Product $product): void;

    public function findById(int $id): Product;

    public function updateProduct(int $id, array $data): void;

    public function deleteProduct(int $id): void;

    public function findByCategory(Category $category): array;

    public function findAll(int $page = 0, int $limit = 0): array;
}