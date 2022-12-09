<?php 
namespace TheStore\Infraestructure\User;

use DI\Container;
use MongoDB\Operation\FindOneAndUpdate;
use Slim\Factory\AppFactory;
use TheStore\Domain\User\Email;
use TheStore\Domain\User\Encoder;
use TheStore\Domain\User\User;
use TheStore\Domain\User\UserRepository;
use TheStore\Infraestructure\ConnectionManager;
use TheStore\Infraestructure\Exceptions\UserNotFound;

use function DI\get;

class UserRepositoryMongo implements UserRepository
{
    private $connection;
    private $mongo;
    private $collection = "users";

    public function __construct()
    {
        $this->connection = ConnectionManager::connect();
        $this->mongo = $this->connection->selectCollection($this->collection);
    }

    public function addUser(User $user): void
    {
        $id = $this->getNextId();

        $document = [
            "_id" => $id,
            "name" => $user->getName(),
            "email" => strval($user->getEmail()),
            "cpf" => strval($user->getCpf()),
            "phone" => [
                "ddd" => $user->getPhone()->getDdd(),
                "number" => $user->getPhone()->getNumber()
            ],
            "address" => [
                "zipcode" => $user->getAddress()->getZipcode(),
                "city" => $user->getAddress()->getCity(),
                "street" => $user->getAddress()->getStreet(),
                "number" => $user->getAddress()->getNumber()
            ],
            "password" => $user->getPassword()
        ];

        $this->mongo->insertOne($document);
    }

    public function findById(int $id): User
    {
        $userFind = $this->mongo->find(['_id' => $id])->toArray();

        if(empty($userFind)) {
            throw new UserNotFound;
        }

        $userFind = current($userFind);
        $user = User::create($userFind['name'], $userFind['cpf'], $userFind['email'], (array) $userFind['phone'], (array) $userFind['address'], $GLOBALS['container']->get("Encoder"));
        $user->setPassword($userFind['password'], true);
        return $user;
    }

    public function findByEmail(Email $email): User
    {
        $userFind = $this->mongo->find(['email' => strval($email)])->toArray();

        if(empty($userFind)) {
            throw new UserNotFound;
        }

        $userFind = current($userFind);
        $user = User::create($userFind['name'], $userFind['cpf'], $userFind['email'], (array) $userFind['phone'], (array) $userFind['address'], $GLOBALS['container']->get("Encoder"));
        $user->setPassword($userFind['password'], true);
        return $user;
    }

    public function findAll(): array
    {
        return $this->mongo->find();
    }

    public function updateUser(int $id, array $data): void
    {
        foreach($data as $key => $value) {
            $this->mongo->updateOne(["_id" => $id], ['$set' => [strval($key) => $value]]);
        }
    }

    public function deleteUser(int $id): void
    {
        $this->mongo->deleteOne(["_id" => $id]);
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
            ['_id' => 'user_id'],
            ['$inc' => ['seq' => 1]],
            ['upsert' => true, 'projection' => [ 'seq' => 1 ],'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );

        return $result['seq'];
    }
}