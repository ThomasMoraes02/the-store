<?php 
namespace TheStore\Application\Helpers;

use MongoDB\Model\BSONDocument;
use TheStore\Domain\Product\Product;

trait ProductHelper
{
    /**
     * Retorna um array de produtos mapeados
     *
     * @return array
     */
    public function mapper($products, $id = null): array
    {
        $url = !empty($_SERVER['SERVER_NAME']) ? SERVER_PROTOCOL . SERVER_NAME . ":" . SERVER_PORT . "/products/" : "/products/";

        if($products instanceof Product) {
            return [
                "id" => $id,
                "title" => $products->getTitle(),
                "price" => $products->getPrice(),
                "description" => $products->getDescription(),
                "amount" => $products->getAmount(),
                "category" => strval($products->getCategory()),
                "_links" => [
                    "product" => [
                        "href" => $url . $id,
                        "title" => $products->getTitle()
                    ]
                ]
            ];
        }

        foreach($products as $product) {
            if(is_array($product) || $product instanceof BSONDocument) {
                $product["_links"] = [
                    "product" => [
                        "href" => $url . $product['_id'],
                        "title" => $product['title']
                    ]
                ];
            }
        }
        return $products;
    }
}