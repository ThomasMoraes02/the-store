<?php 
namespace TheStore\Application\UseCases\Product;

use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\Exceptions\ProductNotFound;

class LoadProduct implements UseCase
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function perform(array $request)
    {
        if($request['id'] != '') {
            $product = $this->repository->findById(intval($request['id']));

            $url = SERVER_PROTOCOL . SERVER_NAME . ":" . SERVER_PORT . "/products/" . $request['id'];

            return [
                "id" => $request['id'],
                "title" => $product->getTitle(),
                "price" => $product->getPrice(),
                "description" => $product->getDescription(),
                "amount" => $product->getAmount(),
                "category" => strval($product->getCategory()),
                "_links" => [
                    "product" => [
                        "href" => $url,
                        "title" => $product->getTitle()
                    ]
                ]
            ];
        }

        $products = $this->repository->findAll($request['page'], $request['limit']);

        if(empty($products)) {
            throw new ProductNotFound;
        }

        foreach($products as $key => $product) {
            $product["_links"] = [
                "product" => [
                    "href" => SERVER_PROTOCOL . SERVER_NAME . ":" . SERVER_PORT . "/products/" . $product['_id'],
                    "title" => $product['title']
                ]
            ];
        }

        return $products;
    }
}