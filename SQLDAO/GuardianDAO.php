<?php

namespace SQLDAO;

use \Exception as Exception;
use Models\Guardian as Guardian;
use Models\User as User;
use SQLDAO\Connection as Connection;
use SQLDAO\IModels as IModels;
use SQLDAO\UserDAO as UserDAO;

class GuardianDAO implements IModels
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

            $queryGuardian = "INSERT INTO " . $this->tableName . " (user_id, cuil, preferred_size_dog,preferred_size_cat ) VALUES (:user_id, :cuil, :preferred_size_dog, :preferred_size_cat);";

            $parametersGuardian["user_id"] = $user->getId();
            $parametersGuardian["cuil"] = $GuardianSQL->getCuil();
            $parametersGuardian["preferred_size_dog"] = $GuardianSQL->getPreferred_size();
            $parametersGuardian["preferred_size_cat"] = $GuardianSQL->getPreferred_size_cat();
            //$parametersGuardian["reputation"] = $GuardianSQL->getReputation();
            //$parametersGuardian["available_date"] = $GuardianSQL->getAvailable_date();
            //$parametersGuardian["price"] = $GuardianSQL->getPrice();

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
            WHERE u.active = true AND t.price IS NOT NULL";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            $UserDAO = new UserDAO();

            foreach ($resultSet as $row) {

                $UserSQL = $UserDAO->LoadData($row);

                $GuardianSQL = $this->LoadData($row, $this->GetAvailableDates($UserSQL->getId()));

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

            $GuardianSQL = $this->LoadData($resultSet[0], $this->GetAvailableDates($UserSQL->getId()));

            $UserSQL->setType_data($GuardianSQL);

            return $UserSQL;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function AddAvailableDates($id, $available_dates)
    {
        try {
            $queryDelete = "DELETE FROM available_dates WHERE guardian_id= " . $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($queryDelete);

            if ($available_dates == []) {
                return NULL;
            }

            $datesString = join("') , (" . $id . ",'", $available_dates);

            $queryInsert = "INSERT INTO available_dates (guardian_id, date) VALUES (" . $id . ", '" . $datesString . "')";

            $this->connection->ExecuteNonQuery($queryInsert);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAvailableDates($id)
    {
        try {

            $query = "SELECT date FROM available_dates WHERE guardian_id= " . $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            if ($resultSet == []) {
                return NULL;
            }

            $available_dates = array_map(function ($dateArray) {

                return $dateArray["date"];
            }, $resultSet);

            return $available_dates;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function SearchGuardiansByFilters($filters)
    {

        $available_dates = array_pop($filters);

        $filtersQuery = array_map(function ($filter) {

            switch ($filter[0]) {

                case "name":
                    return "u.name LIKE '%" . $filter[1] . "%'";
                    break;
                case "reputation":
                    return "t.reputation >= " . $filter[1];
                    break;
                case "preferred_size_dog":
                    return "t.preferred_size_dog = " . $filter[1];
                    break;
                case "preferred_size_cat":
                    return "t.preferred_size_cat = " . $filter[1];
                    break;
                case "adress":
                    return "u.adress LIKE '%" . $filter[1] . "%'";
                    break;
                case "price":
                    return "t.price <= " . $filter[1];
                    break;
                default:
                    return "";
                    break;
            };
        }, $filters);

        try {

            $query = "SELECT u.*, t.cuil, t.reputation, t.price, psd.name as preferred_size_dog, psc.name as preferred_size_cat 
            
        FROM " .  $this->tableName  . " t 
        INNER JOIN users u ON t.user_id=u.user_id
        INNER JOIN pet_sizes psd ON psd.pet_size_id=t.preferred_size_dog    
        INNER JOIN pet_sizes psc ON psc.pet_size_id=t.preferred_size_cat
         WHERE u.active = true AND t.price IS NOT NULL";


            if ($filtersQuery != []) {

                $filtersQuery = join(" AND ", $filtersQuery);

                $query = $query . " AND " . $filtersQuery;
            }

            if ($available_dates[0] == "available_dates" && $available_dates[1] != []) {

                $query = $query . " AND " . count($available_dates[1]) . " IN (SELECT count(date) as dates FROM available_dates WHERE date IN ('" . join("','", $available_dates[1]) . "') AND guardian_id=t.user_id GROUP BY guardian_id)";
            }

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            $UserDAO = new UserDAO();

            $GuardianSQLList = array();

            foreach ($resultSet as $row) {

                $UserSQL = $UserDAO->LoadData($row);

                $GuardianSQL = $this->LoadData($row, $this->GetAvailableDates($UserSQL->getId()));

                $UserSQL->setType_data($GuardianSQL);

                array_push($GuardianSQLList, $UserSQL);
            };

            return $GuardianSQLList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function LoadData($resultSet, $available_dates)
    {
        $GuardianSQL = new Guardian();
        $GuardianSQL->setCuil($resultSet["cuil"]);
        $GuardianSQL->setPreferred_size($resultSet["preferred_size_dog"]);
        $GuardianSQL->setPreferred_size_cat($resultSet["preferred_size_cat"]);
        if ($resultSet["reputation"]) {
            $GuardianSQL->setReputation($resultSet["reputation"]);
        }
        if ($available_dates) {
            $GuardianSQL->setAvailable_date($available_dates);
        } else {
            $GuardianSQL->setAvailable_date(NULL);
        }
        if ($resultSet["price"]) {
            $GuardianSQL->setPrice($resultSet["price"]);
        }

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
