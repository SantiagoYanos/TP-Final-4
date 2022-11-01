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

            $query = "SELECT * FROM " . $this->tableName . " WHERE active=true";

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

            $query = "SELECT * FROM " . $this->tableName . "WHERE user_id=:id AND active=true";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!$resultSet[0]) {
                return null;
            }

            $UserSQL = $this->LoadData($resultSet[0]);

            return $UserSQL;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetByEmail($email)
    {
        try {
            $this->UserList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE email=:email AND active=true;";

            $parameters["email"] = $email;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!$resultSet[0]) {
                return null;
            }

            $UserSQL = $this->LoadData($resultSet[0]);

            return $UserSQL;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function Remove($id)
    {
        try {

            $query = "UPDATE " . $this->tableName . " SET active=false WHERE user_id=:id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
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


    public function getTypeById($id)
    {
        try {
            $this->UserList = array();

            $query = "SELECT user_id, 'guardian' as type FROM guardians where user_id=:id UNION all SELECT user_id, 'owner' as type FROM owners where user_id=:id;";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!$resultSet[0]) {
                return null;
            }

            

            return $resultSet[0];
        } catch (Exception $e) {
            throw $e;
        }


        
    }

    
}
