<?php 
namespace TheStore\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use TheStore\Domain\Exceptions\CpfException;
use TheStore\Domain\User\Cpf;

class CpfTest extends TestCase
{
    public function test_cpf_valid()
    {
        $cpf = new Cpf("123.456.789-09");
        $this->assertEquals($cpf, "123.456.789-09");
    }

    public function test_cpf_invalid()
    {
        $this->expectException(CpfException::class);
        new Cpf("cpf");
    }
}