<?php 
namespace TheStore\Application\UseCases\Product;

use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\Product;
use TheStore\Domain\Product\ProductRepository;

class CreateProduct implements UseCase
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function perform(array $request)
    {
        $product = Product::create($request['title'], $request['price'], $request['description'], $request['amount'], $request['category']);
        $this->repository->addProduct($product);

        return [
            "Product add: {$product->getTitle()}"
        ];
    }
}