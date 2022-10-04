<?php

namespace Models;

class Reservation{
    private $date;
    private $price;
    private $guardian_email;
    private $id_pet;
        

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getGuardian_email()
    {
        return $this->guardian_email;
    }

    public function setGuardian_email($guardian_email)
    {
        $this->guardian_email = $guardian_email;
        return $this;
    }

    public function getId_pet()
    {
        return $this->id_pet;
    }

    public function setId_pet($id_pet)
    {
        $this->id_pet = $id_pet;
        return $this;
    }
}
?>