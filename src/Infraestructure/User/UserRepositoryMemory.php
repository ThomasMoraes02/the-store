<?php 
namespace TheStore\Infraestructure\User;

use TheStore\Domain\User\Email;
use TheStore\Domain\User\User;
use TheStore\Domain\User\UserRepository;
use TheStore\Infraestructure\Exceptions\UserNotFound;

class UserRepositoryMemory implements UserRepository
{
    private array $users = [];

    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }

    public function findById(int $id): User
    {
        $user = $this->findUser($id);
        return current($user);
    }

    public function findByEmail(Email $email): User
    {
        $user = array_filter($this->users, fn($user) => $user->getEmail() == $email);

        if(empty($user)) {
            throw new UserNotFound();
        }

        return current($user);
    }

    public function updateUser(int $id, array $data): void
    {
        $user = $this->findUser($id);
        $user = current($user);

        foreach($data as $key => $value) {
            if(property_exists($user, $key) == true) {
                $set = "set$key";
                $user->$set($value);
            }
        }
    }

    public function deleteUser(int $id): void
    {
        $this->findUser($id);
        unset($this->users[$id]);
    }

    public function findAll(): array
    {
        return $this->users;
    }

    private function findUser(int $id): array
    {
        $user = array_filter($this->users, fn($userId) => $userId == $id, ARRAY_FILTER_USE_KEY);

        if(empty($user)) {
            throw new UserNotFound();
        }

        return $user;
    }
}