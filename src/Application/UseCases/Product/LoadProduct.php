<?php 
namespace TheStore\Application\UseCases\Product;

use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\ProductRepository;

class LoadProduct implements UseCase
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function perform(array $request)
    {
        if($request['id'] == '') {
            $product = $this->repository->findById(intval($request['id']));

            if(empty($product)) {
                return ['Product not found'];
            }

            return [
                "id" => $request['id'],
                "title" => $product->getTitle(),
                "price" => $product->getPrice(),
                "description" => $product->getDescription(),
                "amount" => $product->getAmount(),
                "category" => $product->getCategory()
            ];
        }

        $products = $this->repository->findAll();

        if(empty($product)) {
            return ['Products not found'];
        }
        return $products;
    }
}