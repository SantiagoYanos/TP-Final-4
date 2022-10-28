<?php

namespace SQLDAO;

use \Exception as Exception;
use SQLDAO\IModels as IModels;
use Models\User as User;
use SQLDAO\Connection as Connection;

class UserDAO implements IModels
{
    private $connection;
    private $tableName = "users";

    public function GetAll()
    {
        try {

            $UserList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {

                $UserSQL = $this->LoadData($row);

                array_push($UserList, $UserSQL);
            }

            return $UserList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetById($id)
    {
        try {
            $this->UserList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            $UserSQL = $this->LoadData($resultSet);

            array_push($UserList, $UserSQL);

            return $UserList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function LoadData($resultSet)
    {
        $UserSQL = new User();
        $UserSQL->setId($resultSet["user_id"]);
        $UserSQL->setName($resultSet["name"]);
        $UserSQL->setLast_name($resultSet["last_name"]);
        $UserSQL->setAdress($resultSet["adress"]);
        $UserSQL->setPhone($resultSet["phone"]);
        $UserSQL->setEmail($resultSet["email"]);
        $UserSQL->setPassword($resultSet["password"]);
        $UserSQL->setBirth_date($resultSet["birth_date"]);
        $UserSQL->setType_data(null);

        return $UserSQL;
    }
}
