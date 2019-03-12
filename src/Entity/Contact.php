<?php

namespace App\Entity;

use Symfony\Component\Validation\Constraints AS Assert;


class Contact {

    
    private $firstname;

    
     private $lastname;

    
     private $phone;

    
     private $email;

    
     private $message;

     
     private $vehicule;

   
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

   
    public function setFirstname(?string $firstname): Contact
    {
        $this->firstname = $firstname;
        return $this;
    }

   
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

   
    public function setLastname(?string $lastname): Contact
    {
        $this->lastname = $lastname;
        return $this;
    }

    
    public function getPhone(): ?string
    {
        return $this->phone;
    }

   
    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    
    public function getEmail(): ?string
    {
        return $this->email;
    }

  
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

   
    public function getMessage(): ?string
    {
        return $this->message;
    }

    
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

  
    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    
    public function setVehicule(?Vehicule $vehicule): Contact
    {
        $this->vehicule = $vehicule;
        return $this;
    }

  }
