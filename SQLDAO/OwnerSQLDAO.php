<?php

namespace SQLDAO;

use \Exception as Exception;
use SQLDAO\IOwnerSQLDAO as IOwnerSQLDAO;
use Models\Owner as Owner;
use SQLDAO\Connection as Connection;

class OwnerSQLDAO implements IOwnerSQLDAO
{
    private $OwnerSQLList = array();
    private $connection;
    private $tableName = "owners";

    function removeElementWithValue($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray) {
            if ($subArray[$key] == $value) {
                unset($array[$subKey]);
            }
        }
        return $array;
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

    public function Add(Owner $OwnerSQL)
    {
        $this->RetrieveData();

        try {
            $query = "INSERT INTO " . $this->tableName . " (name, last_name, adress, dni, phone, email, password, birth_date) VALUES (:name, :last_name, :adress, :dni, :phone, :email, :password, :birth_date);";

            $parameters["name"] = $OwnerSQL->getName();
            $parameters["last_name"] = $OwnerSQL->getLast_name();
            $parameters["adress"] = $OwnerSQL->getAdress();
            $parameters["dni"] = $OwnerSQL->getDni();
            $parameters["phone"] = $OwnerSQL->getPhone();
            $parameters["email"] = $OwnerSQL->getEmail();
            $parameters["password"] = $OwnerSQL->getPassword();
            $parameters["birth_date"] = $OwnerSQL->getBirth_date();
            $parameters["active"] = true;


            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }

        array_push($this->OwnerSQLList, $OwnerSQL);

        array_multisort($this->OwnerSQLList);

        $this->SaveData();
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
