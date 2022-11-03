<?php

namespace SQLDAO;

use \Exception as Exception;
use SQLDAO\UserDAO as UserDAO;
use SQLDAO\IOwnerSQLDAO as IOwnerSQLDAO;
use Models\User as User;
use Models\Owner as Owner;
use SQLDAO\IModels as IModels;
use SQLDAO\Connection as Connection;

class OwnerDAO implements IModels
{
    private $OwnerSQLList = array();
    private $connection;
    private $tableName = "owners";

    // function removeElementWithValue($array, $key, $value)
    // {
    //     foreach ($array as $subKey => $subArray) {
    //         if ($subArray[$key] == $value) {
    //             unset($array[$subKey]);
    //         }
    //     }
    //     return $array;
    // }

    // public function activateFromBDD($OwnerSQL)
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

    public function Add(User $UserSQL, Owner $OwnerSQL)
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

            $queryOwner = "INSERT INTO " . $this->tableName . " (user_id, dni) VALUES (:user_id, :dni);";

            $parametersOwner["dni"] = $OwnerSQL->getDni();
            $parametersOwner["user_id"] = $user->getId();

            $this->connection->ExecuteNonQuery($queryOwner, $parametersOwner);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function Edit(User $UserSQL, Owner $OwnerSQL)
    {
        try {
            $queryUser = "UPDATE users SET name=:name, last_name=:last_name, adress=:adress, phone=:phone, birth_date=:birth_date WHERE user_id=:user_id";

            $parametersUser["user_id"] = $UserSQL->getId();
            $parametersUser["name"] = $UserSQL->getName();
            $parametersUser["last_name"] = $UserSQL->getLast_name();
            $parametersUser["adress"] = $UserSQL->getAdress();
            $parametersUser["phone"] = $UserSQL->getPhone();
            $parametersUser["birth_date"] = $UserSQL->getBirth_date();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($queryUser, $parametersUser);

            $queryOwner = "UPDATE " . $this->tableName . " SET dni=:dni WHERE user_id=:user_id";

            $parametersOwner["user_id"] = $UserSQL->getId();
            $parametersOwner["dni"] = $OwnerSQL->getDni();

            $this->connection->ExecuteNonQuery($queryOwner, $parametersOwner);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetAll()
    {
        try {
            $OwnersSQLList = array();

            $query = "SELECT * FROM " . $this->tableName . " g INNER JOIN users u ON g.user_id=u.user_id WHERE u.active=true";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            $UserDAO = new UserDAO();

            foreach ($resultSet as $row) {

                $UserSQL = $UserDAO->LoadData($row);

                $OwnerSQL = $this->LoadData($row);

                $UserSQL->setType_data($OwnerSQL);

                array_push($OwnerSQLList, $UserSQL);
            }

            return $OwnerSQLList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetById($id)
    {

        try {
            $query = "SELECT * FROM " . $this->tableName . " t INNER JOIN users u ON t.user_id=u.user_id WHERE u.user_id = " . $id . " AND u.active = true";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            if (!$resultSet[0]) {
                return null;
            }

            $userDAO = new UserDAO();

            $UserSQL = $userDAO->LoadData($resultSet[0]);

            $OwnerSQL = $this->LoadData($resultSet[0]);

            $UserSQL->setType_data($OwnerSQL);

            return $UserSQL;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function LoadData($resultSet)
    {
        $OwnerSQL = new Owner();
        $OwnerSQL->setDni($resultSet["dni"]);

        return $OwnerSQL;
    }
}
