<?php

namespace App\Entity;

use Symfony\Component\Validator\Constrains as Assert;

class Contact {

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
     private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     * pattern="/[0-9]{10}/"
     * )
     */
     private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email
     */
     private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
     private $message;

     /**
      * @var Vehicule|null
      */
     private $vehicule;

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return Contatct
     */
    public function setFirstname(?string $firstname): Contatct
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return Contatct
     */
    public function setLastname(?string $lastname): Contatct
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return Contatct
     */
    public function setPhone(?string $phone): Contatct
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Contatct
     */
    public function setEmail(?string $email): Contatct
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Contatct
     */
    public function setMessage(?string $message): Contatct
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return Vehicule|null
     */
    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    /**
     * @param Vehicule|null $vehicule
     * @return Contatct
     */
    public function setVehicule(?Vehicule $vehicule): Contatct
    {
        $this->vehicule = $vehicule;
        return $this;
    }

  }
