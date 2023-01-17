<?php

namespace SQLDAO;

use \Exception as Exception;
use Models\Review as Review;
use SQLDAO\Connection as Connection;

class ReviewDAO 
{

    private $ReviewList = array();
    private $connection;
    private $tableName = "reviews";
    public function GetAll()
    {
        try {

            $ReviewList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE active=true";

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {

                $ReviewSQL = $this->LoadData($row);

                array_push($ReviewList, $ReviewSQL);
            }

            return $ReviewList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function LoadData($resultSet)
    {
        $ReviewSQL = new Review();
        $ReviewSQL->setId($resultSet["review_id"]);
        $ReviewSQL->setOwner_name($resultSet["owner_name"]);
        $ReviewSQL->setComment($resultSet["comment"]);
        $ReviewSQL->setRating($resultSet["rating"]);
        $ReviewSQL->setOwnerId($resultSet["review_owner_id"]);
        $ReviewSQL->setGuardianId($resultSet["review_guardian_id"]);
        $ReviewSQL->setDate($resultSet["date"]);
        return $ReviewSQL;
    }

    public function GetById($guardianId)
    {
        try {

            $ReviewList = array();

            $query = "SELECT r.*, CONCAT(u.name, ' ', u.last_name)  as 'owner_name' FROM " . $this->tableName . " r WHERE review_guardian_id=:guardianId  AND active=true inner join users u on  review_owner_id = user_id  ";

            $parameters["guardianId"] = $guardianId;
            

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {

                $ReviewSQL = $this->LoadData($row);

                array_push($ReviewList, $ReviewSQL);
            }

            return $ReviewList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function calculateRating ($guardianId)
    {
        try{
        $query = "SELECT sum(r.rating)/ count(review_id) as promedio FROM " . $this->tableName . " r WHERE review_guardian_id=:guardianId  AND active=true ";

        $parameters["guardianId"] = $guardianId;
        

        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query, $parameters);

       

        return $resultSet[0]["promedio"];
    } catch (Exception $e) {
        throw $e;
    }

    }

}