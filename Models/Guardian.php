<?php

namespace Models;

class Guardian
{
    private $cuil;
    private $preferred_size;
    private $preferred_size_cat;
    private $reputation;
    private $available_date;
    private $price;
    private $user_id;

    public function getCuil()
    {
        return $this->cuil;
    }

    public function setCuil($cuil)
    {
        $this->cuil = $cuil;

        return $this;
    }

    public function getPreferred_size()
    {
        return $this->preferred_size;
    }

    public function setPreferred_size($preferred_size)
    {
        $this->preferred_size = $preferred_size;

        return $this;
    }

    public function getPreferred_size_cat()
    {
        return $this->preferred_size_cat;
    }

    public function setPreferred_size_cat($preferred_size_cat)
    {
        $this->preferred_size_cat = $preferred_size_cat;

        return $this;
    }

    public function getReputation()
    {
        return $this->reputation;
    }

    public function setReputation($reputation)
    {
        $this->reputation = $reputation;

        return $this;
    }

    public function getAvailable_date()
    {
        return $this->available_date;
    }

    public function setAvailable_date($available_date)
    {
        $this->available_date = $available_date;

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

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_Id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
}
