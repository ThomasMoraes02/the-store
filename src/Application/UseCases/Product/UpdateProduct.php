<?php 
namespace TheStore\Application\UseCases\Product;

use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\ProductRepository;

class UpdateProduct implements UseCase
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function perform(array $request)
    {
        $id = $request['id'];
        unset($request['id']);
        $this->repository->updateProduct(intval($id), $request);

        return $this->repository->findById($id);
    }
}