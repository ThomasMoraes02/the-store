<?php 
namespace TheStore\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use TheStore\Domain\User\Address;
use TheStore\Domain\User\Cpf;
use TheStore\Domain\User\Email;
use TheStore\Domain\User\Phone;
use TheStore\Domain\User\User;
use TheStore\Infraestructure\User\EncoderArgonII;

class UserTest extends TestCase
{
    public function test_create_user()
    {
        $user = new User("Thomas Moraes", new Cpf("123.456.789-09"), new Email("thomas@gmail.com"), new Phone("11", "926173511"), new Address("06515210", "City", "Street", "1"), new EncoderArgonII);
        $user->setPassword("123456");

        $this->assertEquals($user->getName(), "Thomas Moraes");
        $this->assertEquals($user->getEmail(), "thomas@gmail.com");
    }
}