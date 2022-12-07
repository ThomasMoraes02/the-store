<?php 
namespace TheStore\Tests\Infraestructure\User;

use TheStore\Domain\User\User;
use PHPUnit\Framework\TestCase;
use TheStore\Domain\User\Email;
use TheStore\Domain\User\UserRepository;
use TheStore\Infraestructure\User\EncoderArgonII;
use TheStore\Infraestructure\Exceptions\UserNotFound;
use TheStore\Infraestructure\User\UserRepositoryMemory;

class UserRepositoryMemoryTest extends TestCase
{
    private User $user;
    private UserRepository $repository;

    protected function setUp(): void
    {
        $user = User::create("Thomas Moraes", "123.456.789-09", "thomas@gmail.com", ["11", "965873259"], ["0598234", "city", "street", "11"], new EncoderArgonII);
        $user->setPassword("123456");
        $this->user = $user;
        
        $this->repository = new UserRepositoryMemory;
        $this->repository->addUser($this->user);
    }

    public function test_add_user()
    {
        $this->assertNotEmpty($this->repository->findAll());
    }

    public function test_find_user_by_email()
    {
        $user = $this->repository->findByEmail(new Email("thomas@gmail.com"));
        $this->assertEquals("Thomas Moraes", $user->getName());
    }

    public function test_find_by_id()
    {
        $user = $this->repository->findById(0);
        $this->assertEquals("Thomas Moraes", $user->getName());
    }

    public function test_delete_user()
    {
        $this->expectException(UserNotFound::class);
        $user = User::create("Thomas Moraes 2", "123.456.789-09", "thomas2@gmail.com", ["11", "960073259"], ["0598234", "city", "street", "11"], new EncoderArgonII);
        $user->setPassword("654321");

        $this->repository->addUser($user);
        $this->repository->deleteUser(1);
        $this->repository->findById(1);
    }

    public function test_update_user()
    {
        $data = [
            "name" => "Thomas Vinicius",
            "email" => "thomas2test@gmail.com"
        ];

        $this->repository->updateUser(0, $data);
        $user = $this->repository->findById(0);
        $this->assertEquals($user->getName(), "Thomas Vinicius");
        $this->assertEquals($user->getEmail(), "thomas2test@gmail.com");
    }
}