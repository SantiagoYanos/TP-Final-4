<?php

namespace SQLDAO;

use \Exception as Exception;
use Models\Guardian as Guardian;
use Models\User as User;
use Models\Owner as Owner;
use Models\Reservation as Reservation;
use SQLDAO\Connection as Connection;
use SQLDAO\IModels as IModels;
use SQLDAO\UserDAO as UserDAO;
use SQLDAO\PetDAO as PetDAO;

class ReservationDAO implements IModels
{
    private $connection;
    private $tableName = "reservations";

    /*public function Add(Reservation $reservation, $reservation_dates, $pets_ids)
    {
        try {
            $queryReservation = "CALL create_Reservation(:price, :guardian_id, :owner_id);";

            $parametersReservation["price"] = $reservation->getPrice();
            $parametersReservation["guardian_id"] = $reservation->getGuardian_id();
            $parametersReservation["owner_id"] = $reservation->getOwner_id();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($queryReservation, $parametersReservation);

            if ($resultSet) {

                $id_reservation = $resultSet[0]["id_reservation"];

                $datesString = join("') , (" . $id_reservation . ",'", $reservation_dates);

                $queryDates = "INSERT INTO reservations_x_dates (reservation_id, date ) VALUES (" . $id_reservation . ", '" . $datesString . "')";

                $petsString = join(") , (" . $id_reservation . ",", $pets_ids);

                $queryPetsReservations = " INSERT INTO reservations_x_pets (reservation_id, pet_id ) VALUES (" . $id_reservation . "," . $petsString . ")";

                $this->connection->ExecuteNonQuery($queryDates);

                $this->connection->ExecuteNonQuery($queryPetsReservations);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }*/

    public function Add(Reservation $reservation, $reservation_dates, $pets_ids)
    {
        try {
            $queryReservation = "CALL create_Reservation(:price, :guardian_id, :owner_id);";

            $parametersReservation["price"] = $reservation->getPrice();
            $parametersReservation["guardian_id"] = $reservation->getGuardian_id();
            $parametersReservation["owner_id"] = $reservation->getOwner_id();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($queryReservation, $parametersReservation);

            if ($resultSet) {

                $id_reservation = $resultSet[0]["id_reservation"];

                $datesString = join("') , (" . $id_reservation . ",'", $reservation_dates);
                $queryDates = "INSERT INTO reservations_x_dates (reservation_id, date ) VALUES (:reservation_id, '" . $datesString . "')";
                $parametersDates["reservation_id"] = $id_reservation;

                $petsString = join(") , (" . $id_reservation . ",", $pets_ids);
                $queryPetsReservations = " INSERT INTO reservations_x_pets (reservation_id, pet_id ) VALUES (:reservation_id," . $petsString . ")";
                $parametersPetsReservations["reservation_id"] = $id_reservation;

                $this->connection->ExecuteNonQuery($queryDates, $parametersDates);

                $this->connection->ExecuteNonQuery($queryPetsReservations, $parametersPetsReservations);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateState($reservation_id, $state)
    {
        try {
            $query = "UPDATE reservations SET state = :state WHERE reservation_id = :reservation_id";

            $parameters["state"] = $state;
            $parameters["reservation_id"] = $reservation_id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {

            $query = "SELECT * FROM " . $this->tableName . ";";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            if (!$resultSet[0]) {
                return [];
            }

            $reservationList = array();

            foreach ($resultSet as $reservation) {

                $getReservation = $this->LoadData($reservation);

                $getDates = $this->GetDates($getReservation->getId());

                $getReservation->setDates($getDates);

                $getPets = $this->GetPets($getReservation->getId());

                $getReservation->setPets($getPets);

                array_push($reservationList, $getReservation);
            }

            return $reservationList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAllByDates($guardian_id, $dates = [])
    {
        if ($dates) {
            try {
                foreach ($dates as $date) {
                    //$query = "SELECT * FROM " . $this->tableName . ";";

                    //$query = "select * from " . $this->tableName. " inner join reservations_x_dates rxd on reservations.reservation_id = rxd.reservation_id where date = " . "'$date'" ." and guardian_id= " . $guardian_id .";";
                    $query = "select * from " . $this->tableName . " inner join reservations_x_dates rxd on reservations.reservation_id = rxd.reservation_id where date =:date and guardian_id=:guardian_id;";

                    $parameters["date"] = $date;
                    $parameters["guardian_id"] = $guardian_id;

                    $this->connection = Connection::GetInstance();

                    $resultSet = $this->connection->Execute($query, $parameters);

                    if (!$resultSet[0]) {
                        return [];
                    }

                    $reservationList = array();

                    foreach ($resultSet as $reservation) {

                        $getReservation = $this->LoadData($reservation);

                        $getDates = $this->GetDates($getReservation->getId());

                        $getReservation->setDates($getDates);

                        $getPets = $this->GetPets($getReservation->getId());

                        $getReservation->setPets($getPets);

                        array_push($reservationList, $getReservation);
                    }
                }
                return $reservationList;
            } catch (Exception $ex) {
                throw $ex;
            }
        }
    }

    public function GetById($id)
    {

        try {
            ///$queryReservation = "SELECT * FROM " . $this->tableName . " WHERE active=true AND reservation_id = " . $id . ";";

            $queryReservation = "SELECT * FROM " . $this->tableName . " WHERE active=true AND reservation_id = :id ;";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($queryReservation, $parameters);

            if (!$resultSet[0]) {
                return null;
            }

            $getReservation = $this->LoadData($resultSet[0]);

            $getDates = $this->GetDates($getReservation->getId());

            $getReservation->setDates($getDates);

            $getPets = $this->GetPets($getReservation->getId());

            $getReservation->setPets($getPets);

            return $getReservation;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetByGuardianOrOwner($id, $type)
    {
        $reservationList = array();
        /* 
        $type = "guardian" OR "owner"
        
        */

        try {

            if ($type == "guardian") {
                $queryType = "guardian_id = :id ;";
            } else {
                $queryType = "owner_id = :id ;";
            }

            $queryReservation = "SELECT * FROM " . $this->tableName . " WHERE active=true AND " . $queryType;

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($queryReservation, $parameters);

            if (!$resultSet || $resultSet == []) {
                return [];
            }

            foreach ($resultSet as $reservation) {

                $getReservation = $this->LoadData($reservation);

                $getDates = $this->GetDates($getReservation->getId());

                $getReservation->setDates($getDates);

                $getPets = $this->GetPets($getReservation->getId());

                $getReservation->setPets($getPets);

                array_push($reservationList, $getReservation);
            }

            return $reservationList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function GetDates($id)
    {
        try {

            $query = "SELECT * FROM reservations_x_dates WHERE reservation_id = :id;";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            if (!$resultSet[0]) {
                return [];
            }

            $datesArray = array_map(function ($dateArray) {
                return $dateArray["date"];
            }, $resultSet);

            return $datesArray;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetPets($id)
    {
        $query = "SELECT rp.reservation_id, p.* FROM reservations_x_pets rp INNER JOIN pets p ON rp.pet_id = p.pet_id WHERE reservation_id = :id ;";

        $parameters["id"] = $id;

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->Execute($query, $parameters);

        if (!$resultSet[0]) {
            return [];
        }

        $petDAO = new PetDAO();

        $petsArray = array_map(function ($pet) use ($petDAO) {

            $newPet = $petDAO->LoadData($pet);

            return $newPet;
        }, $resultSet);

        return $petsArray;
    }

    public function getExistingReservations($arrayDates)
    {

        $datesJson = json_encode($arrayDates);

        $datesJson = ltrim($datesJson, '[');

        $datesJson = rtrim($datesJson, ']');

        $query = 'SELECT r.reservation_id,
        count(date) as include_dates,
        p.pet_id,
        p.name,
        p.pet_type,
        p.pet_size,
        p.pet_breed,
        p.observations
       FROM reservations_x_dates rd 
       INNER JOIN reservations r ON rd.reservation_id = r.reservation_id
       INNER JOIN reservations_x_pets rp ON r.reservation_id = rp.reservation_id
       INNER JOIN pets p ON rp.pet_id = p.pet_id
       WHERE date IN (' . $datesJson . ') AND r.state = "Accepted" AND r.active=true
       GROUP BY r.reservation_id
       HAVING include_dates >=1 LIMIT 1';

        $this->connection = Connection::GetInstance();

        $resultSet = $this->connection->Execute($query);

        if (!$resultSet) {
            return null;
        }

        if ($resultSet[0]) {
            $petDAO = new PetDAO();

            $pet = $petDAO->LoadData($resultSet[0]);

            return $pet;
        } else {
            return null;
        }
    }

    public function LoadData($resultSet)
    {
        $ReservationSQL = new Reservation();
        $ReservationSQL->setId($resultSet["reservation_id"]);
        $ReservationSQL->setPrice($resultSet["price"]);
        $ReservationSQL->setGuardian_id($resultSet["guardian_id"]);
        $ReservationSQL->setOwner_id($resultSet["owner_id"]);
        $ReservationSQL->setState($resultSet["state"]);

        return $ReservationSQL;
    }
}
