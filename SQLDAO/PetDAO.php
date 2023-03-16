<?php

namespace SQLDAO;

use \Exception as Exception;
use SQLDAO\IModels as IModels;
use Models\Pet as Pet;
use SQLDAO\Connection as Connection;

class PetDAO implements IModels
{
    private $connection;
    private $tableName = "pets";

    public function GetAll()
    {
        try {

            $PetList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE active=true";

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $pet) {

                $petSQL = $this->LoadData($pet);

                array_push($PetList, $petSQL);
            }

            return $PetList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE pet_id=:id AND active=true";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!$resultSet[0]) {
                return null;
            }

            $petSQL = $this->LoadData($resultSet[0]);

            return $petSQL;
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function Remove($id)
    {
        try {

            $query = "UPDATE " . $this->tableName . " SET active=false WHERE pet_id=:id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function LoadData($resultSet)
    {
        $petSQL = new Pet();
        $petSQL->setId($resultSet["pet_id"]);
        $petSQL->setName($resultSet["name"]);
        $petSQL->setSize($resultSet["pet_size"]);
        $petSQL->setBreed($resultSet["pet_breed"]);
        $petSQL->setObservation($resultSet["observations"]);
        $petSQL->setType($resultSet["pet_type"]);
        if (isset($resultSet["owner_id"])) {
            $petSQL->setOwner_id($resultSet["owner_id"]);
        }
        if (isset($resultSet["vaccination_plan"])) {
            $petSQL->setVaccination_plan($resultSet["vaccination_plan"]);
        }
        if (isset($resultSet["pet_img"])) {
            $petSQL->setPet_img($resultSet["pet_img"]);
        }
        if (isset($resultSet["pet_video"])) {
            $petSQL->setPet_video($resultSet["pet_video"]);
        }

        return $petSQL;
    }

    public function Add(Pet $PetSQL)
    {
        try {
            $queryPet = "CALL insertPet(:name, :pet_type, :pet_size, :pet_breed, :observations, :owner_id, :vaccination_plan, :pet_img, :pet_video)"; /*"INSERT INTO pets (name, pet_type, pet_size, pet_breed, observations, owner_id, vaccination_plan, pet_img, pet_video) VALUES (:name, :pet_type, :pet_size, :pet_breed, :observations, :owner_id, :vaccination_plan, :pet_img, :pet_video);"*/

            $parametersPet["name"] = $PetSQL->getName();

            $parametersPet["pet_type"] = $PetSQL->getType();
            $parametersPet["pet_size"] = $PetSQL->getSize();
            $parametersPet["pet_breed"] = $PetSQL->getBreed();
            $parametersPet["observations"] = $PetSQL->getObservation();
            $parametersPet["owner_id"] = $PetSQL->getOwner_id();
            $parametersPet["vaccination_plan"] = $PetSQL->getVaccination_plan();
            $parametersPet["pet_img"] = $PetSQL->getPet_img();
            $parametersPet["pet_video"] = $PetSQL->getPet_video();


            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($queryPet, $parametersPet);

            if (!$resultSet[0]) {
                return null;
            }
            return $resultSet[0]["id_pet"];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetPetsByOwner($owner_id)
    {
        try {

            $PetList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE owner_id=:owner_id AND active=true";

            $parameters["owner_id"] = $owner_id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {

                $petsQL = $this->LoadData($row);

                array_push($PetList, $petsQL);
            }

            return $PetList;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
