<?php 
namespace TheStore\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use TheStore\Domain\Exceptions\PhoneException;
use TheStore\Domain\User\Phone;

class PhoneTest extends TestCase
{
    public function test_create_phone()
    {
        $phone = new Phone("11", "972173967");
        $this->assertEquals($phone, "(11) 972173967");
    }

    public function test_phone_invalid()
    {
        $this->expectException(PhoneException::class);
        new Phone("1", "1");
    }
}