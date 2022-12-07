<?php 
namespace TheStore\Infraestructure\Product;

use TheStore\Domain\Product\Product;
use MongoDB\Operation\FindOneAndUpdate;
use TheStore\Domain\Product\Category;
use TheStore\Domain\Product\ProductRepository;
use TheStore\Infraestructure\ConnectionManager;
use TheStore\Infraestructure\Exceptions\ProductNotFound;

class ProductRepositoryMongo implements ProductRepository
{
    private $connection;
    private $mongo;
    private $collection = "products";

    public function __construct()
    {
        $this->connection = ConnectionManager::connect();
        $this->mongo = $this->connection->selectCollection($this->collection);
    }
    
    public function addProduct(Product $product): void
    {
        $id = $this->getNextId();

        $document = [
            "_id" => $id,
            "title" => $product->getTitle(),
            "price" => $product->getPrice(),
            "description" => $product->getDescription(),
            "amount" => $product->getAmount(),
            "category" => $product->getCategory()
        ];

        $this->mongo->insertOne($document);
    }

    public function findById(int $id): Product
    {
        $product = $this->mongo->find(['_id' => $id])->toArray();

        if(empty($product)) {
            throw new ProductNotFound;
        }

        $product = current($product);
        return Product::create($product['title'], $product['price'], $product['description'], $product['amount'], $product['category']);
    }

    public function findByCategory(Category $category): array
    {
        return $this->mongo->find(['category' => $category])->toArray();
    }

    public function updateProduct(int $id, array $data): void
    {
        foreach($data as $key => $value) {
            $this->mongo->updateOne(["_id" => $id], ['$set' => [strval($key) => $value]]);
        }
    }

    public function deleteProduct(int $id): void
    {
        $this->mongo->deleteOne(["id" => $id]);
    }

    public function findAll(): array
    {
        return $this->mongo->find()->toArray();
    }

    /**
     * Gera um id auto incremento
     *
     * @return int
     */
    private function getNextId(): int
    {
        $collection = $this->connection->selectCollection("counters");

        $result = $collection->findOneAndUpdate(
            ['_id' => 'product_id'],
            ['$inc' => ['seq' => 1]],
            ['upsert' => true, 'projection' => [ 'seq' => 1 ],'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );

        return $result['seq'];
    }
}