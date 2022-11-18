<?php

namespace DAO;

use DAO\UserDAO as UserDAO;
use Models\Guardian as Guardian;
use Models\User as User;

class GuardianDAO implements IModels
{
    private $guardianList = array();
    private $fileName = ROOT . "Data/guardians.json";

    function Add(User $user, Guardian $guardian)
    {
        $userDAO = new UserDAO();

        $this->RetrieveData();

        $newId = $userDAO->Add($user);

        $newUser = new User();

        $newUser->setId($newId);

        $guardian->setUser_id($newId);

        $guardian->setReputation(3);

        $newUser->setType_data($guardian);

        array_push($this->guardianList, $newUser);

        $this->SaveData();
    }

    function Edit(User $user, Guardian $guardianEdit)
    {
        $userDAO = new UserDAO();

        $this->RetrieveData();

        $guardians = array_map(function ($guardian) use ($user, $guardianEdit, $userDAO) {

            if ($guardian->getId() == $user->getId()) {

                $userDAO->Edit($user);

                $guardian->setType_data($guardianEdit);
            }

            return $guardian;
        }, $this->guardianList);

        $this->guardianList = $guardians;

        $this->SaveData();
    }

    function GetAll()
    {
        $this->RetrieveData();

        return $this->guardianList;
    }

    function GetById($id)
    {
        $this->RetrieveData();

        $guardians = array_filter($this->guardianList, function ($guardian) use ($id) {
            return $guardian->getId() == $id;
        });

        $guardians = array_values($guardians); //Reorderding array

        return (count($guardians) > 0) ? $guardians[0] : null;
    }

    function GetByEmail($email)
    {
        $this->RetrieveData();

        $guardians = array_filter($this->guardianList, function ($guardian) use ($email) {

            return $guardian->getEmail() == $email;
        });

        $guardians = array_values($guardians);

        return (count($guardians) > 0) ? $guardians[0] : null;
    }

    function Remove($id)
    {
        $userDAO = new UserDAO();

        $this->RetrieveData();

        $this->guardianList = array_filter($this->guardianList, function ($guardian) use ($id, $userDAO) {

            if ($guardian->getId() == $id) {
                $userDAO->Remove($id);
            }

            return $guardian->getId() != $id;
        });

        $this->SaveData();
    }

    private function RetrieveData()
    {
        $this->guardianList = array();

        if (file_exists($this->fileName)) {
            $jsonToDecode = file_get_contents($this->fileName);

            $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();

            $userDAO = new UserDAO();

            foreach ($contentArray as $content) {

                switch ($content["preferred_size"]) {
                    case 1:
                        $content["preferred_size"] = "big";
                        break;
                    case 2:
                        $content["preferred_size"] = "medium";
                        break;
                    case 3:
                        $content["preferred_size"] = "small";
                        break;
                }

                switch ($content["preferred_size_cat"]) {
                    case 1:
                        $content["preferred_size_cat"] = "big";
                        break;
                    case 2:
                        $content["peeferred_size_cat"] = "medium";
                        break;
                    case 3:
                        $content["preferred_size_cat"] = "small";
                        break;
                }

                $user = $userDAO->getById($content["user_id"]);

                $guardian = $this->LoadData($content, $content["available_date"]);

                $user->setType_data($guardian);

                array_push($this->guardianList, $user);

                //guardianList es una lista de Usuarios con Type_data de Guardianes
            }
        }
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->guardianList as $user) {

            $guardian = $user->getType_data();

            $valuesArray = array();
            $valuesArray["user_id"] = $user->getId();
            $valuesArray["cuil"] = $guardian->getCuil();
            $valuesArray["preferred_size"] = $guardian->getPreferred_size();
            $valuesArray["preferred_size_cat"] = $guardian->getPreferred_size_cat();
            $valuesArray["reputation"] = $guardian->getReputation();
            $valuesArray["price"] = $guardian->getPrice();
            $valuesArray["available_date"] = $guardian->getAvailable_date();
            array_push($arrayToEncode, $valuesArray);
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }

    /*function UpdateAvailableDates($email, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday)
    {
        $this->RetrieveData();

        $guardians = array_map(function ($guardian) use ($email, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday) {

            if ($guardian->getEmail() == $email) {
                $valuesArray = array();
                $valuesArray["monday"] = $monday;
                $valuesArray["tuesday"] = $tuesday;
                $valuesArray["wednesday"] = $wednesday;
                $valuesArray["thursday"] = $thursday;
                $valuesArray["friday"] = $friday;
                $valuesArray["saturday"] = $saturday;
                $valuesArray["sunday"] = $sunday;
                $guardian->setAvailable_date($valuesArray);
            }

            return $guardian;
        }, $this->guardianList);

        $this->guardianList = $guardians;

        $this->SaveData();
    }*/

    public function AddAvailableDates($id, $availableDates)
    {
        $this->RetrieveData();

        $guardians = array_map(function ($guardian) use ($id, $availableDates) {

            if ($guardian->getId() == $id) {

                $guardian->getType_data()->setAvailable_date($availableDates);
            }

            return $guardian;
        }, $this->guardianList);

        $this->guardianList = $guardians;

        $this->SaveData();
    }

    public function GetAvailableDates($id)
    {
        $this->RetrieveData();

        $guardians = array_filter($this->guardianList, function ($guardian) use ($id) {

            return $guardian->getId() == $id;
        });

        if (!$guardians[0]) {
            return null;
        }

        return $guardians[0]->getType_data()->getAvailable_date();
    }

    public function SearchGuardiansByFilters($filters)
    {
        $this->RetrieveData();

        return $this->guardianList;

        //No estaba en la primera entrega (Retorna todos los guardianes)
    }

    // function UpdateAvailableDates($user_id, $availableDates)
    // {
    //     $this->RetrieveData();

    //     $guardians = array_map(function ($guardian) use ($email, $availableDates) {

    //         if ($guardian->getEmail() == $email) {

    //             $guardian->setAvailable_date($availableDates);
    //         }

    //         return $guardian;
    //     }, $this->guardianList);

    //     $this->guardianList = $guardians;

    //     $this->SaveData();
    // }

    public function LoadData($resultSet, $available_dates)
    {
        $Guardian = new Guardian();
        $Guardian->setUser_id($resultSet["user_id"]);
        $Guardian->setCuil($resultSet["cuil"]);
        $Guardian->setPreferred_size($resultSet["preferred_size"]);
        $Guardian->setPreferred_size_cat($resultSet["preferred_size_cat"]);
        if ($resultSet["reputation"]) {
            $Guardian->setReputation($resultSet["reputation"]);
        }
        if ($available_dates) {
            $Guardian->setAvailable_date($available_dates);
        } else {
            $Guardian->setAvailable_date(NULL);
        }
        if ($resultSet["price"]) {
            $Guardian->setPrice($resultSet["price"]);
        }

        return $Guardian;
    }
}
