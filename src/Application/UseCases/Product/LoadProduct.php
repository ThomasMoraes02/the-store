<?php 
namespace TheStore\Application\UseCases\Product;

use MongoDB\Model\BSONDocument;
use TheStore\Application\UseCases\UseCase;
use TheStore\Domain\Product\Product;
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

        $page = $request['page'] ?? 0;
        $limit = $request['limit'] ?? 0;

        $products = $this->repository->findAll($page,$limit);

        if(empty($products)) {
            throw new ProductNotFound;
        }

        return $this->mapperArray($products);
    }

    private function mapperArray(array $products): array
    {
        foreach($products as $product) {
            if(is_array($product) || $product instanceof BSONDocument) {
                $product["_links"] = [
                    "product" => [
                        "href" => SERVER_PROTOCOL . SERVER_NAME . ":" . SERVER_PORT . "/products/" . $product['_id'],
                        "title" => $product['title']
                    ]
                ];
            }
        }
        return $products;
    }
}