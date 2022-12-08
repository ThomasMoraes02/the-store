<?php 
namespace TheStore\Application\UseCases\Product;

use MongoDB\Model\BSONDocument;
use TheStore\Application\Helpers\ProductHelper;
use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\Product;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\Exceptions\ProductNotFound;

class LoadProduct implements UseCase
{
    use ProductHelper;

    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function perform(array $request)
    {
        if($request['id'] != '') {
            $product = $this->repository->findById(intval($request['id']));
            return $this->mapper($product, $request['id']);
        }

        $page = $request['page'] ?? 0;
        $limit = $request['limit'] ?? 0;

        $products = $this->repository->findAll($page,$limit);

        if(empty($products)) {
            throw new ProductNotFound;
        }

        return $this->mapper($products);
    }
}