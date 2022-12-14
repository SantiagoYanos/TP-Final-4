<?php

namespace DAO;

use DAO\IModels as IModels;
use Models\Pet as Pet;

class PetDAO implements IModels
{
    private $pet_list = array();
    private $fileName = ROOT . "Data/pet.json";

    function Add(pet $pet)
    {
        $this->RetrieveData();
        $pet->setId($this->getNextId());
        array_push($this->pet_list, $pet);
        $this->SaveData();
        return $pet->getId();
    }

    function GetAll()
    {
        $this->RetrieveData();
        return $this->pet_list;
    }

    function GetById($id)
    {
        $this->RetrieveData();
        $pets = array_filter($this->pet_list, function ($pet) use ($id) {
            return $pet->getId() == $id;
        });

        $pets = array_values($pets);
        return (count($pets) > 0) ? $pets[0] : null;
    }

    function Remove($id)
    {
        $this->RetrieveData();

        $this->pet_list = array_filter($this->pet_list, function ($pet) use ($id) {
            return $pet->getId() != $id;
        });

        $this->SaveData();

    }

    private function RetrieveData()
    {
        $this->pet_list = array();

        if (file_exists($this->fileName)) {
            $jsonToDecode = file_get_contents($this->fileName);

            $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();

            foreach ($contentArray as $content) {
                $pet = $this->jsonToPet($content);

                array_push($this->pet_list, $pet);
            }
        }
    }

    private function jsonToPet($content)
    {
        $pet = new Pet();

        $pet->setId($content["id"]);
        $pet->setName($content["name"]);
        $pet->setSize($content["size"]);
        $pet->setVaccination_plan($content["vaccination_plan"]);
        $pet->setObservation($content["observation"]);
        $pet->setBreed($content["breed"]);
        $pet->setOwner_id($content["owner_id"]);
        $pet->setType($content["type"]);
        $pet->setPet_img($content["pet_img"]);
        $pet->setPet_video($content["pet_video"]);

        return $pet;
    }

    public function GetPetsByOwner($owner_id)
    {
        //$new_pet_list = array();
        $this->RetrieveData();
        $new_pet_list = array_filter($this->pet_list, function ($pet) use ($owner_id) {
            return $pet->getOwner_id() == $owner_id;
        });

        return $new_pet_list;
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->pet_list as $pet) {

            $petArray = $this->PetToArray($pet);

            array_push($arrayToEncode, $petArray);
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }

    public function PetToArray($pet)
    {
        $valuesPet = array();
        $valuesPet["id"] = $pet->getId();
        $valuesPet["name"] = $pet->getName();
        $valuesPet["size"] = $pet->getSize();
        $valuesPet["vaccination_plan"] = $pet->getVaccination_plan();
        $valuesPet["observation"] = $pet->getObservation();
        $valuesPet["breed"] = $pet->getBreed();
        $valuesPet["owner_id"] = $pet->getOwner_id();
        $valuesPet["type"] = $pet->getType();
        $valuesPet["pet_img"] = $pet->getPet_img();
        $valuesPet["pet_video"] = $pet->getPet_video();

        return $valuesPet;
    }


    private function GetNextId()
    {
        $id = 0;
        foreach ($this->pet_list as $pet) {
            $id = ($pet->getId() > $id) ? $pet->getId() : $id;
        }

        return $id + 1;
    }
}
