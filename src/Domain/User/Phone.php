<?php 
namespace TheStore\Domain\User;

use TheStore\Domain\Exceptions\PhoneException;

class Phone
{
    private int $ddd;
    private int $number;

    public function __construct(int $ddd, int $number)
    {
        $this->setDdd($ddd);
        $this->setNumber($number);
    }

    private function setDdd(int $ddd): void
    {
        if(strlen($ddd) != 2) {
            throw new PhoneException("This DDD is invalid $ddd");
        }
        $this->ddd = $ddd;
    }

    private function setNumber(int $number)
    {
        if(strlen($number) != 9) {
            throw new PhoneException("This number is invalid: $number");
        }
        $this->number = $number;
    }

    public function __toString(): string
    {
        return "({$this->ddd}) {$this->number}";
    }
}