<?php

namespace Models;

class Payment {
    private $id;
    private $amount;
    private $date;
    private $payment_method;
    private $guardian_id;
    private $owner_id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this->id;
    }
 
    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
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

    public function getPayment_method()
    {
        return $this->payment_method;
    }

    public function setPayment_method($payment_method)
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getGuardian_id()
    {
        return $this->guardian_email;
    }

    public function setGuardian_id($guardian_email)
    {
        $this->guardian_email = $guardian_email;

        return $this;
    }

    public function getOwner_id()
    {
        return $this->owner_email;
    }

    public function setOwner_id($owner_email)
    {
        $this->owner_email = $owner_email;

        return $this;
    }
}