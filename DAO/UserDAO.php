<?php

namespace DAO;

use DAO\IModels as IModels;
use Models\User as User;

use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;


class UserDAO implements IModels
{
    private $userList = array();
    private $fileName = ROOT . "Data/users.json";

    function Add(User $user)
    {
        $this->RetrieveData();

        $newId = $this->GetNextId();

        $user->setId($newId);

        array_push($this->userList, $user);

        $this->SaveData();

        return $newId;
    }

    function Edit($userEdit)
    {
        $this->RetrieveData();

        $users = array_map(function ($user) use ($userEdit) {

            if ($user->getId() == $userEdit->getId()) {

                $userEdit->setEmail($user->getEmail());

                $userEdit->setPassword($user->getPassword());

                $user = $userEdit;
            }

            return $user;
        }, $this->userList);

        $this->userList = $users;

        $this->SaveData();
    }

    function GetAll()
    {
        $this->RetrieveData();

        return $this->userList;
    }

    function GetById($id)
    {
        $this->RetrieveData();

        $users = array_filter($this->userList, function ($user) use ($id) {
            return $user->getId() == $id;
        });

        $users = array_values($users); //Reorderding array

        return (count($users) > 0) ? $users[0] : null;
    }

    function GetByEmail($email)
    {
        $this->RetrieveData();

        $users = array_filter($this->userList, function ($user) use ($email) {

            return $user->getEmail() == $email;
        });

        $users = array_values($users);

        return (count($users) > 0) ? $users[0] : null;
    }

    function Remove($id)
    {
        $this->RetrieveData();

        $this->userList = array_filter($this->userList, function ($user) use ($id) {
            return $user->getId() != $id;
        });

        $this->SaveData();
    }

    private function RetrieveData()
    {
        $this->userList = array();

        if (file_exists($this->fileName)) {
            $jsonToDecode = file_get_contents($this->fileName);

            $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();

            foreach ($contentArray as $content) {

                $user = $this->LoadData($content);

                array_push($this->userList, $user);
            }
        }
    }

    // --------------- Para Guardian DAO ----------------------------

    // function UpdateAvailableDates($email, $availableDates)
    // {
    //     $this->RetrieveData();

    //     $guardians = array_map(function ($guardian) use ($email, $availableDates) {

    //         if ($guardian->getId() == $id) {

    //             $guardian->setAvailable_date($availableDates);
    //         }

    //         return $guardian;
    //     }, $this->guardianList);

    //     $this->guardianList = $guardians;

    //     $this->SaveData();
    // }

    public function GetNextId()
    {
        $id = 0;

        foreach ($this->userList as $user) {
            $id = ($user->getId() > $id) ? $user->getId() : $id;
        }

        return $id + 1;
    }

    public function LoadData($resultSet)
    {
        $User = new User();
        $User->setId($resultSet["user_id"]);
        $User->setName($resultSet["name"]);
        $User->setLast_name($resultSet["last_name"]);
        $User->setAdress($resultSet["adress"]);
        $User->setPhone($resultSet["phone"]);
        $User->setEmail($resultSet["email"]);
        $User->setPassword($resultSet["password"]);
        $User->setBirth_date($resultSet["birth_date"]);
        $User->setType_data(null);

        return $User;
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->userList as $user) {
            $valuesArray = array();
            $valuesArray["user_id"] = $user->getId();
            $valuesArray["name"] = $user->getName();
            $valuesArray["last_name"] = $user->getLast_name();
            $valuesArray["adress"] = $user->getAdress();
            $valuesArray["phone"] = $user->getPhone();
            $valuesArray["email"] = $user->getEmail();
            $valuesArray["password"] = $user->getPassword();
            $valuesArray["birth_date"] = $user->getBirth_date();
            array_push($arrayToEncode, $valuesArray);
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }

    public function getTypeById($id)
    {
        $guardianDAO = new GuardianDAO();

        $ownerDAO = new OwnerDAO();

        $user = $guardianDAO->GetById($id);

        if ($user) {

            $userType = array();

            $userType["id"] = $id;
            $userType["type"] = "guardian";

            return $userType;
        }

        $user = $ownerDAO->GetById($id);

        if ($user) {

            $userType = array();

            $userType["id"] = $id;
            $userType["type"] = "owner";

            return $userType;
        }

        return null;
    }
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