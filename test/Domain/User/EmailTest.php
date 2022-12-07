<?php 
namespace TheStore\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use TheStore\Domain\User\Email;
use TheStore\Domain\Exceptions\EmailException;

class EmailTest extends TestCase
{
    public function test_email_valid()
    {
        $email = new Email("thomas@gmail.com");
        $this->assertEquals($email, "thomas@gmail.com");
    }

    public function test_email_invalid()
    {
        $this->expectException(EmailException::class);
        new Email("invalid");
    }
}
