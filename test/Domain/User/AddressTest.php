<?php 
namespace TheStore\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use TheStore\Domain\User\Address;

class AddressTest extends TestCase
{
    public function test_create_address()
    {
        $address = new Address("06515210", "Santana de Parnaiba", "Rua Colorado", "161");
        $this->assertEquals("06515210", $address->getZipcode());
        $this->assertEquals("Santana de Parnaiba", $address->getCity());
    }
}