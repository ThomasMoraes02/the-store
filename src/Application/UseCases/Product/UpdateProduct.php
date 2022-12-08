<?php 
namespace TheStore\Application\UseCases\Product;

use TheStore\Application\Helpers\ProductHelper;
use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\ProductRepository;

class UpdateProduct implements UseCase
{
    use ProductHelper;

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

        $product = $this->repository->findById($id);
        return $this->mapper($product, $id);
    }
}