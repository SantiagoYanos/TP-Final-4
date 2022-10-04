<?php

namespace Models;

class Guardian
{
    private $id;
    private $cuil;
    private $name;
    private $adress;
    private $phone;
    private $prefered_size;
    private $reputation;
    private $price;
    private $email;
    private $password;
    private $available_date;



    




    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * 
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of cuil
     */ 
    public function getCuil()
    {
        return $this->cuil;
    }

    /**
     * Set the value of cuil
     *
     * 
     */ 
    public function setCuil($cuil)
    {
        $this->cuil = $cuil;

        return $this;
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
     * 
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of adress
     */ 
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set the value of adress
     *
     * 
     */ 
    public function setAdress($adress)
    {
        $this->adress = $adress;

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
     * 
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of prefered_size
     */ 
    public function getPrefered_size()
    {
        return $this->prefered_size;
    }

    /**
     * Set the value of prefered_size
     *
     * 
     */ 
    public function setPrefered_size($prefered_size)
    {
        $this->prefered_size = $prefered_size;

        return $this;
    }

    /**
     * Get the value of reputation
     */ 
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * Set the value of reputation
     *
     * 
     */ 
    public function setReputation($reputation)
    {
        $this->reputation = $reputation;

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
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * 
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the value of email
     *
     * 
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of available_date
     */ 
    public function getAvailable_date()
    {
        return $this->available_date;
    }

    /**
     * Set the value of available_date
     *
     * 
     */ 
    public function setAvailable_date($available_date)
    {
        $this->available_date = $available_date;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}























?>