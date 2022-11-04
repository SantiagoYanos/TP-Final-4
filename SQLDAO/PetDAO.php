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

            foreach ($resultSet as $row) {

                $petsQL = $this->LoadData($row);

                array_push($PetList, $petsQL);
            }

            return $PetList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function GetById($id)
    {
        try {
            $this->PetList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE pet_id=:id AND active=true";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!$resultSet[0]) {
                return null;
            }

            $petsQL = $this->LoadData($resultSet[0]);

            return $petsQL;
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
        $petsQL = new Pet();
        $petsQL->setId($resultSet["pet_id"]);
        $petsQL->setName($resultSet["name"]);
        $petsQL->setSize($resultSet["pet_size"]);
        $petsQL->setBreed($resultSet["pet_breed"]);
        $petsQL->setObservation($resultSet["observations"]);
        $petsQL->setType($resultSet["pet_type"]);
        $petsQL->setOwner_id($resultSet["owner_id"]);
        $petsQL->setVaccination_plan($resultSet["vaccination_plan"]);
        $petsQL->setPet_img($resultSet["pet_img"]);
        $petsQL->setPet_video($resultSet["pet_video"]);
        
        

        return $petsQL;
    }
    
    public function Add(Pet $PetSQL)
    {
        try {
            $queryPet = "INSERT INTO pets (name, pet_size, pet_breed, observations, pet_type, owner_id,vaccination_note, pet_img, pet_video) VALUES (:name, :pet_size, :pet_breed, :observations, :pet_type, :owner_id, :vaccination_note, :pet_img, :pet_video);";

            $parametersPet["name"] = $PetSQL->getName();
            $parametersPet["pet_size"] = $PetSQL->getSize();
            $parametersPet["pet_breed"] = $PetSQL->getBreed();
            $parametersPet["observations"] = $PetSQL->getObservation();
            $parametersPet["pet_type"] = $PetSQL->getType();
            $parametersPet["owner_id"] = $PetSQL->getOwner_id();
            $parametersPet["vaccination_note"] = $PetSQL->getOwner_id();
            $parametersPet["pet_img"] = $PetSQL->getOwner_id();
            $parametersPet["pet_video"] = $PetSQL->getOwner_id();
            

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($queryPet, $parametersPet);
            /*
            $PetDAO = new PetDAO();

            $pet = $PetDAO->GetById($PetSQL->getId());
            
            if (!$pet) {
                return null;
            }
            
            $queryPetMultimedia = "INSERT INTO " . "pet_multimedia" . " (file_path, pet_id, description ) VALUES (:file_path, :pet_id, :description);";

            $parametersMultimedia["file_path"] = $PetSQL->getVaccination_plan();
            $parametersMultimedia["pet_id"] = $pet->getId();
            $parametersMultimedia["description"] = "vaccination_note";
            

            $this->connection->ExecuteNonQuery($queryPetMultimedia, $parametersMultimedia);
            */
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