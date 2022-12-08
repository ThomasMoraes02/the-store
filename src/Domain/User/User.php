<?php 
namespace TheStore\Domain\User;

use TheStore\Domain\User\Cpf;
use TheStore\Domain\User\Email;
use TheStore\Domain\User\Phone;
use TheStore\Domain\User\Address;
use TheStore\Domain\User\Encoder;

class User
{
    private string $name;
    private Cpf $cpf;
    private Email $email;
    private Phone $phone;
    private Address $address;
    private Encoder $encoder;
    private string $password;

    public function __construct(string $name, Cpf $cpf, Email $email, Phone $phone, Address $address, Encoder $encoder)
    {
        $this->name = $name;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->encoder = $encoder;
    }

    public static function create(string $name, string $cpf, string $email, array $phone, array $address, Encoder $encoder): User
    {
        return new User($name, new Cpf($cpf), new Email($email), new Phone($phone["ddd"], $phone["number"]), new Address($address["zipcode"], $address["city"], $address["street"], $address["number"]), $encoder);
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $this->encoder->encode($password);

        return $this;
    }

    /**
     * Get the value of cpf
     */ 
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */ 
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = new Email($email);

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
}