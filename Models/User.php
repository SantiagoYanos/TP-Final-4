<?php

namespace Models;

class User
{
    private $id;
    private $name;
    private $last_name;
    private $adress;
    private $phone;
    private $email;
    private $password;
    private $birth_date;
    private $type_data;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this->name;
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

    public function getBirth_date()
    {
        return $this->birth_date;
    }

    public function setBirth_date($birth_date)
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getType_data()
    {
        return $this->type_data;
    }

    public function setType_data($type_data)
    {
        $this->type_data = $type_data;

        return $this;
    }
}
