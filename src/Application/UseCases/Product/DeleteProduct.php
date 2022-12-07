<?php 
namespace TheStore\Application\UseCases\Product;

use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\ProductRepository;

class DeleteProduct implements UseCase
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function perform(array $request)
    {
        $this->repository->findById(intval($request['id']));
        $this->repository->deleteProduct(intval($request['id']));

        return [
            "Product Deleted"
        ];
    }
}