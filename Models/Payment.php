<?php

namespace Models;

class Payment {
    private $amount;
    private $date;
    private $payment_method;
    private $guardian_email;
    private $owner_email;
 
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

    public function getGuardian_email()
    {
        return $this->guardian_email;
    }

    public function setGuardian_email($guardian_email)
    {
        $this->guardian_email = $guardian_email;

        return $this;
    }

    public function getOwner_email()
    {
        return $this->owner_email;
    }

    public function setOwner_email($owner_email)
    {
        $this->owner_email = $owner_email;

        return $this;
    }
}