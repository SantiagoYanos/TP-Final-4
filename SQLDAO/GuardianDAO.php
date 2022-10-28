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

    public function activateFromBDD($OwnerSQL)
    {
        try {
            $query  = "UPDATE " . $this->tableName . " SET active ='" . 1 . "' where owner_id =" . $OwnerSQL->getOwnerSQLId();

            $this->connection  = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteFromBDD($OwnerSQL)
    {
        try {
            $query  = "UPDATE " . $this->tableName . " SET active ='" . 0 . "' where owner_id =" . $OwnerSQL->getOwnerSQLId();

            $this->connection  = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function editBDD(Owner $OwnerSQL)
    {
        try {
            $query1  = "UPDATE " . $this->tableName . " SET name='" . $OwnerSQL->getName() . "' where owner_id = " . $OwnerSQL->getId();
            $query2  = "UPDATE " . $this->tableName . " SET email ='" . $OwnerSQL->getEmail() . "' where owner_id =" . $OwnerSQL->getId();
            $query3  = "UPDATE " . $this->tableName . " SET phone ='" . $OwnerSQL->getPhone() . "' where owner_id =" . $OwnerSQL->getId();
            $query4  = "UPDATE " . $this->tableName . " SET password ='" . $OwnerSQL->getPassword() . "' where owner_id =" . $OwnerSQL->getId();
            $query5  = "UPDATE " . $this->tableName . " SET last_name ='" . $OwnerSQL->getLast_name() . "' where owner_id =" . $OwnerSQL->getId();
            $query6  = "UPDATE " . $this->tableName . " SET adress ='" . $OwnerSQL->getAdress() . "' where owner_id =" . $OwnerSQL->getId();
            $query7  = "UPDATE " . $this->tableName . " SET dni ='" . $OwnerSQL->getDni() . "' where owner_id =" . $OwnerSQL->getId();
            $query8  = "UPDATE " . $this->tableName . " SET birht_date ='" . $OwnerSQL->getBirth_date() . "' where owner_id =" . $OwnerSQL->getId();

            $this->connection  = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query1);
            $this->connection->ExecuteNonQuery($query2);
            $this->connection->ExecuteNonQuery($query3);
            $this->connection->ExecuteNonQuery($query4);
            $this->connection->ExecuteNonQuery($query5);
            $this->connection->ExecuteNonQuery($query6);
            $this->connection->ExecuteNonQuery($query7);
            $this->connection->ExecuteNonQuery($query8);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetAllBDD()
    {
        try {
            $OwnerSQLList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $OwnerSQL = new Owner();
                $OwnerSQL->setId($row["owner_id"]);
                $OwnerSQL->setName($row["name"]);
                $OwnerSQL->setLast_name($row["last_name"]);
                $OwnerSQL->setAdress($row["adress"]);
                $OwnerSQL->setDni($row["dni"]);
                $OwnerSQL->setPhone($row["phone"]);
                $OwnerSQL->setEmail($row["email"]);
                $OwnerSQL->setPassword($row["password"]);
                $OwnerSQL->setBirth_date($row["birth_date"]);

                array_push($OwnerSQLList, $OwnerSQL);
            }

            return $OwnerSQLList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetByIdBDD($id)
    {

        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE owner_id = " . $id . "and active = true";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $OwnerSQL = new Owner();

                $OwnerSQL->setDni($row["dni"]);

                return $OwnerSQL;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
