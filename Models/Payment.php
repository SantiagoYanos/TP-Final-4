<?php

namespace Models;

class Payment
{
    private $amount;
    private $date;
    private $reservation_id;
    private $owner_id;
    private $guardian_id;
    private $payment_number;

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

    public function getReservation_id()
    {
        return $this->reservation_id;
    }

    public function setReservation_id($reservation_id)
    {
        $this->reservation_id = $reservation_id;

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

    public function getGuardian_id()
    {
        return $this->guardian_id;
    }

    public function setGuardian_id($guardian_id)
    {
        $this->guardian_id = $guardian_id;

        return $this;
    }

    public function getPayment_number()
    {
        return $this->payment_number;
    }

    public function setPayment_number($payment_number)
    {
        $this->payment_number = $payment_number;

        return $this;
    }
}
