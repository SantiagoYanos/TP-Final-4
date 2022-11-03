<?php

namespace Models;

class Reservation{

    private $id;
    private $date;
    private $price;
    private $guardian_id;
    private $id_pet;
    private $available_dates;

    public function setAvailable_Dates($date){
        $this->available_dates = $date;
    }

    public function getAvailable_Dates(){
        return $this->available_dates;
    }

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

    public function getGuardian_id()
    {
        return $this->guardian_id;
    }

    public function setGuardian_id($guardian_id)
    {
        $this->guardian_id = $guardian_id;
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
 
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
