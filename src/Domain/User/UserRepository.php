<?php 
namespace TheStore\Domain\User;

interface UserRepository
{
    public function addUser(User $user): void;

    public function findById(int $id): User;

    public function findByEmail(Email $email): User;

    public function updateUser(int $id, array $data): void;

    public function deleteUser(int $id): void;

    public function findAll(): array;
}