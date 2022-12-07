<?php 
namespace TheStore\Domain\User;

use TheStore\Domain\Exceptions\EmailException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    private function setEmail(string $email): void
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            throw new EmailException($email);
        }
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}