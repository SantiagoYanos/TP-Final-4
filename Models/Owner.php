<?php

namespace Models;

class Owner
{
    private $id;
    private $name;
    private $last_name;
    private $adress;
    private $dni;
    private $phone;
    private $pets;
    private $email;
    private $password;
    private $birth_date;
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this->name;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this->dni;
    }

    public function getLast_name()
    {
        return $this->last_name;
    }

    public function setLast_name($last_name)
    {
        $this->last_name =  $last_name;
    }

    public function getAdress()
    {
        return $this->adress;
    }

    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this->phone;
    }

    public function getPets()
    {
        return $this->pets;
    }

    public function setPets($pets)
    {
        $this->pets = $pets;

        return $this->pets;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this->password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this->id;
    }

    public function getBirth_date()
    {
        return $this->birth_date;
    }

    public function setBirth_date($birth_date)
    {
        $this->birth_date = $birth_date;

        return $this;
    }
}
