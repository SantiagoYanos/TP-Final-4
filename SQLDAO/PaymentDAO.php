<?php

namespace SQLDAO;

use SQLDAO\IModels as IModels;
// use SQLDAO\GuardianDAO as GuardianDAO;
// use SQLDAO\OwnerDAO as OwnerDAO;
// use SQLDAO\ReservationDAO as ReservationDAO;
use Models\Payment as Payment;
use PaymentNotFoundException;

class PaymentDAO implements IModels
{
    private $connection;

    public function GetAll()
    {
        $query = "SELECT p.amount, p.date, p.payment_number, CONCAT(uo.name, ' ', uo.last_name) as 'owner_name', CONCAT(ug.name, ' ', ug.last_name) as 'guardian_name', r.price
        FROM payments p 
        INNER JOIN users uo ON uo.user_id = p.owner_id
        INNER JOIN users ug ON ug.user_id = p.guardian_id
        INNER JOIN reservations r ON r.reservation_id = p.reservation_id;";

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->Execute($query);

        return $resultSet;
    }

    public function GetById($id)
    {
        $query = "SELECT p.amount as 'amount', p.date as 'date', p.payment_number as 'payment_number', CONCAT(uo.name, ' ', uo.last_name) as 'owner_name', CONCAT(ug.name, ' ', ug.last_name) as 'guardian_name', r.price as 'price'
        FROM payments p 
        INNER JOIN users uo ON uo.user_id = p.owner_id
        INNER JOIN users ug ON ug.user_id = p.guardian_id
        INNER JOIN reservations r ON r.reservation_id = p.reservation_id
        WHERE p.payment_id = :payment_id;";

        $parameters["payment_id"] = $id;

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->Execute($query, $parameters);

        if (!$resultSet || $resultSet == []) {
            return null;
        }

        $PaymentSQL = $this->LoadData($resultSet[0]);

        return $PaymentSQL;
    }

    public function Add($payment)
    {
        $query = "INSERT INTO payments (amount, date, reservation_id, owner_id, guardian_id, payment_number) VALUES (:amount, now(), :reservation_id, :owner_id, :guardian_id, :payment_number)";

        $parameters["amount"] = $payment->getAmount();
        $parameters["reservation_id"] = $payment->getReservation_id();
        $parameters["owner_id"] = $payment->getOwner_id();
        $parameters["guardian_id"] = $payment->getGuardian_id();
        $parameters["payment_number"] = $payment->getPayment_number();

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->Execute($query, $parameters);

        if (!$resultSet[0]) {
            return null;
        }
        return $resultSet[0]["payment_id"];
    }

    public function GetByReservationId($reservation_id)
    {
        $query = "SELECT p.amount as 'amount', p.date as 'date', p.payment_number as 'payment_number', CONCAT(uo.name, ' ', uo.last_name) as 'owner_name', CONCAT(ug.name, ' ', ug.last_name) as 'guardian_name', r.price as 'price'

        FROM payments p 
        INNER JOIN users uo ON uo.user_id = p.owner_id
        INNER JOIN users ug ON ug.user_id = p.guardian_id
        INNER JOIN reservations r ON r.reservation_id = p.reservation_id
        WHERE r.reservation_id = :reservation_id;";

        $parameters["reservation_id"] = $reservation_id;

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->Execute($query, $parameters);

        if (!$resultSet || $resultSet == []) {
            return null;
        }

        $PaymentSQL = $this->LoadData($resultSet[0]);

        return $PaymentSQL;
    }

    public function LoadData($resultSet)
    {
        $PaymentSQL = new Payment();
        $PaymentSQL->setAmount($resultSet["amount"]);
        $PaymentSQL->setDate($resultSet["date"]);
        $PaymentSQL->setPayment_number($resultSet["payment_number"]);
        $PaymentSQL->setOwner_name($resultSet["owner_name"]);
        $PaymentSQL->setGuardian_name($resultSet["guardian_name"]);
        $PaymentSQL->setPrice($resultSet["price"]);

        return $PaymentSQL;
    }
}
