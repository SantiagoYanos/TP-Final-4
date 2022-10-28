<?php

namespace SQLDAO;

use \Exception as Exception;
use Models\Guardian as Guardian;
use Models\User as User;
use SQLDAO\Connection as Connection;
use SQLDAO\IModels as IModels;
use SQLDAO\UserDAO as UserDAO;

class OwnerDAO implements IModels
{
    private $connection;
    private $tableName = "guardians";

    public function Add(User $UserSQL, Guardian $GuardianSQL)
    {
        try {

            $queryUser = "INSERT INTO users (name, last_name, adress, phone, email, password, birth_date) VALUES (:name, :last_name, :adress, :phone, :email, :password, :birth_date);";

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

            $queryGuardian = "INSERT INTO" . $this->tableName . "(user_id, cuil, preferred_size_dog,preferred_size_cat, reputation, available_date, price) VALUES (:user_id, :cuil, :preferred_size_dog, :preferred_size_cat, :reputation, :available_date, :price);";

            $parametersGuardian["user_id"] = $user->getId();
            $parametersGuardian["cuil"] = $GuardianSQL->getCuil();
            $parametersGuardian["preferred_size_dog"] = $GuardianSQL->getPreferred_size();
            $parametersGuardian["preferred_size_cat"] = $GuardianSQL->getPreferred_size_cat();
            $parametersGuardian["reputation"] = $GuardianSQL->getReputation();
            $parametersGuardian["available_date"] = $GuardianSQL->getAvailable_date();
            $parametersGuardian["price"] = $GuardianSQL->getPrice();

            $this->connection->ExecuteNonQuery($queryGuardian, $parametersGuardian);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetAll()
    {
        try {
            $GuardianSQLList = array();

            $query = "SELECT * FROM " . $this->tableName . "g INNER JOIN users u ON g.user_id=u.user_id WHERE u.active=true";

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
            $query = "SELECT * FROM " . $this->tableName . "t INNER JOIN users u ON t.user_id=u.user_id WHERE u.user_id = " . $id . "AND u.active = true";

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
        $GuardianSQL->setReputation($resultSet["reputation"]);
        $GuardianSQL->setAvailable_date($resultSet["available_date"]);
        $GuardianSQL->setPrice($resultSet["price"]);

        return $GuardianSQL;
    }

    // public function Activate($UserSQL)
    // {
    //     try {
    //         $query  = "UPDATE " . $this->tableName . " SET active ='" . 1 . "' where owner_id =" . $OwnerSQL->getOwnerSQLId();

    //         $this->connection  = Connection::GetInstance();
    //         $this->connection->ExecuteNonQuery($query);
    //     } catch (Exception $e) {
    //         throw $e;
    //     }
    // }

    // public function deleteFromBDD($OwnerSQL)
    // {
    //     try {
    //         $query  = "UPDATE " . $this->tableName . " SET active ='" . 0 . "' where owner_id =" . $OwnerSQL->getOwnerSQLId();

    //         $this->connection  = Connection::GetInstance();
    //         $this->connection->ExecuteNonQuery($query);
    //     } catch (Exception $e) {
    //         throw $e;
    //     }
    // }

    // public function editBDD(Owner $OwnerSQL)
    // {
    //     try {
    //         $query1  = "UPDATE " . $this->tableName . " SET name='" . $OwnerSQL->getName() . "' where owner_id = " . $OwnerSQL->getId();
    //         $query2  = "UPDATE " . $this->tableName . " SET email ='" . $OwnerSQL->getEmail() . "' where owner_id =" . $OwnerSQL->getId();
    //         $query3  = "UPDATE " . $this->tableName . " SET phone ='" . $OwnerSQL->getPhone() . "' where owner_id =" . $OwnerSQL->getId();
    //         $query4  = "UPDATE " . $this->tableName . " SET password ='" . $OwnerSQL->getPassword() . "' where owner_id =" . $OwnerSQL->getId();
    //         $query5  = "UPDATE " . $this->tableName . " SET last_name ='" . $OwnerSQL->getLast_name() . "' where owner_id =" . $OwnerSQL->getId();
    //         $query6  = "UPDATE " . $this->tableName . " SET adress ='" . $OwnerSQL->getAdress() . "' where owner_id =" . $OwnerSQL->getId();
    //         $query7  = "UPDATE " . $this->tableName . " SET dni ='" . $OwnerSQL->getDni() . "' where owner_id =" . $OwnerSQL->getId();
    //         $query8  = "UPDATE " . $this->tableName . " SET birht_date ='" . $OwnerSQL->getBirth_date() . "' where owner_id =" . $OwnerSQL->getId();

    //         $this->connection  = Connection::GetInstance();
    //         $this->connection->ExecuteNonQuery($query1);
    //         $this->connection->ExecuteNonQuery($query2);
    //         $this->connection->ExecuteNonQuery($query3);
    //         $this->connection->ExecuteNonQuery($query4);
    //         $this->connection->ExecuteNonQuery($query5);
    //         $this->connection->ExecuteNonQuery($query6);
    //         $this->connection->ExecuteNonQuery($query7);
    //         $this->connection->ExecuteNonQuery($query8);
    //     } catch (Exception $e) {
    //         throw $e;
    //     }
    // }

}
