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

class ReservationDAO implements IModels
{
    private $connection;
    private $tableName = "reservations";

    public function Add(Reservation $reservation, User $UserSQL, Guardian $GuardianSQL)
    {
        try {

            $queryUser = "INSERT INTO reservations (id, date, price, guardian_id, id_pet) VALUES (:id, :date, :price, :guardian_id, :id_pet);";

            $parametersUser["name"] = $UserSQL->getName();
            $parametersUser["last_name"] = $UserSQL->getLast_name();
            $parametersUser["adress"] = $UserSQL->getAdress();
            $parametersUser["phone"] = $UserSQL->getPhone();
            $parametersUser["email"] = $UserSQL->getEmail();
            $parametersUser["password"] = $UserSQL->getPassword();
            $parametersUser["birth_date"] = $UserSQL->getBirth_date();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($queryUser, $parametersUser);

            $userDAO = new UserDAO();

            $user = $userDAO->GetByEmail($UserSQL->getEmail());

            if (!$user) {
                return null;
            }

            $queryGuardian = "INSERT INTO " . $this->tableName . " (user_id, cuil, preferred_size_dog,preferred_size_cat ) VALUES (:user_id, :cuil, :preferred_size_dog, :preferred_size_cat);";

            $parametersGuardian["user_id"] = $user->getId();
            $parametersGuardian["cuil"] = $GuardianSQL->getCuil();
            $parametersGuardian["preferred_size_dog"] = $GuardianSQL->getPreferred_size();
            $parametersGuardian["preferred_size_cat"] = $GuardianSQL->getPreferred_size_cat();

            $this->connection->ExecuteNonQuery($queryGuardian, $parametersGuardian);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetAll()
    {
        try {
            $GuardianSQLList = array();

            $query = "SELECT u.*, t.cuil, t.reputation, t.price, psd.name as preferred_size_dog, psc.name as preferred_size_cat 
            FROM " . $this->tableName  . " t 
            INNER JOIN users u ON t.user_id=u.user_id
            INNER JOIN pet_sizes psd ON psd.pet_size_id=t.preferred_size_dog
            INNER JOIN pet_sizes psc ON psc.pet_size_id=t.preferred_size_cat
            WHERE u.active = true";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            $UserDAO = new UserDAO();

            foreach ($resultSet as $row) {

                $UserSQL = $UserDAO->LoadData($row);

                $GuardianSQL = $this->LoadData($row);

                $UserSQL->setType_data($GuardianSQL);

                array_push($GuardianSQLList, $UserSQL);
            }

            return $GuardianSQLList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetById($id)
    {

        try {
            $query =
                "SELECT u.*, t.cuil, t.reputation, t.price, psd.name as preferred_size_dog, psc.name as preferred_size_cat 
            FROM " . $this->tableName  . " t 
            INNER JOIN users u ON t.user_id=u.user_id
            INNER JOIN pet_sizes psd ON psd.pet_size_id=t.preferred_size_dog
            INNER JOIN pet_sizes psc ON psc.pet_size_id=t.preferred_size_cat
            WHERE u.user_id = " . $id . " AND u.active = true";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            if (!$resultSet[0]) {
                return null;
            }

            $userDAO = new UserDAO();

            $UserSQL = $userDAO->LoadData($resultSet[0]);

            $GuardianSQL = $this->LoadData($resultSet[0]);

            $UserSQL->setType_data($GuardianSQL);

            return $UserSQL;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function LoadData($resultSet)
    {
        $GuardianSQL = new Guardian();
        $GuardianSQL->setCuil($resultSet["cuil"]);
        $GuardianSQL->setPreferred_size($resultSet["preferred_size_dog"]);
        $GuardianSQL->setPreferred_size_cat($resultSet["preferred_size_cat"]);
        if ($resultSet["reputation"]) {
            $GuardianSQL->setReputation($resultSet["reputation"]);
        }

        if ($resultSet["price"]) {
            $GuardianSQL->setPrice($resultSet["price"]);
        }

        return $GuardianSQL;
    }
}
