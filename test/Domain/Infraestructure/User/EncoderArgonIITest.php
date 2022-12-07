<?php 
namespace TheStore\Tests\Domain\Infraestructure\User;

use PHPUnit\Framework\TestCase;
use TheStore\Infraestructure\User\EncoderArgonII;

class EncoderArgonIITest extends TestCase
{
    public function test_encoder_password()
    {
        $encoder = new EncoderArgonII;
        $password = $encoder->encode("123456");
        $passwordDecoded = $encoder->decode("123456", $password);

        $this->assertNotEmpty($password);
        $this->assertTrue($passwordDecoded);
    }

    public function test_encoder_invalid()
    {
        $encoder = new EncoderArgonII;
        $password = $encoder->encode("123456");
        $passwordDecoded = $encoder->decode("1", $password);

        $this->assertFalse($passwordDecoded);        
    }
}