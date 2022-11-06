<?php

namespace Models;

class Reservation
{

    private $id;
    private $price;
    private $guardian_id;
    private $owner_id;
    private $pets;
    private $dates;
    private $state;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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

    public function getOwner_id()
    {
        return $this->owner_id;
    }

    public function setOwner_id($owner_id)
    {
        $this->owner_id = $owner_id;
        return $this;
    }

    public function getPets()
    {
        return $this->pets;
    }

    public function setPets($pets)
    {
        $this->pets = $pets;
        return $this;
    }

    public function setDates($dates)
    {
        $this->dates = $dates;
    }

    public function getDates()
    {
        return $this->dates;
    }

    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function getState()
    {
        return $this->state;
    }
}
