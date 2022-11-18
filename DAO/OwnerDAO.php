<?php

namespace DAO;

use DAO\IModels as IModels;
use Models\User as User;
use Models\Owner as Owner;
use Models\Pet as Pet;
use DAO\UserDAO as UserDAO;
use DAO\PetDAO as PetDAO;

class OwnerDAO implements IModels
{
    private $ownerList = array();
    private $fileName = ROOT . 'Data/owners.json';

    function Add(User $user, Owner $owner)
    {
        $userDAO = new UserDAO();

        $this->RetrieveData();

        $newId = $userDAO->Add($user);

        $newUser = new User();

        $newUser->setId($newId);

        $owner->setUser_id($newId);

        $newUser->setType_data($owner);

        array_push($this->ownerList, $newUser);

        $this->SaveData();
    }


    function Edit(User $user, Owner $ownerEdit)
    {
        $userDAO = new UserDAO();

        $this->RetrieveData();

        $owners = array_map(function ($owner) use ($user, $ownerEdit, $userDAO) {

            if ($owner->getId() == $user->getId()) {

                $userDAO->Edit($user);

                $owner->setType_data($ownerEdit);
            }

            return $owner;
        }, $this->ownerList);

        $this->ownerList = $owners;

        $this->SaveData();
    }

    function GetAll()
    {
        $this->RetrieveData();

        return $this->ownerList;
    }

    function GetById($id)
    {
        $this->RetrieveData();

        $owners = array_filter($this->ownerList, function ($owner) use ($id) {

            return $owner->getId() == $id;
        });

        $owners = array_values($this->ownerList);

        if (count($owners) > 0) {
            return $owners[0];
        } else {
            return null;
        }
    }

    function GetByEmail($email)
    {
        $this->RetrieveData();

        $owners = array_filter($this->ownerList, function ($owner) use ($email) {
            return $owner->getEmail() == $email;
        });

        $owners = array_values($owners);

        if (count($owners) > 0) {
            return $owners[0];
        } else {
            return null;
        }
    }

    function Remove($id)
    {
        $userDAO = new UserDAO();

        $this->RetrieveData();

        $this->ownerList = array_filter($this->ownerList, function ($owner) use ($id, $userDAO) {

            if ($owner->getId() == $id) {
                $userDAO->Remove($id);
            }

            return $owner->getId() != $id;
        });

        $this->SaveData();
    }

    private function RetrieveData()
    {
        $this->ownerList = array();

        if (file_exists($this->fileName)) {
            $jsonToDecode = file_get_contents($this->fileName);

            $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();

            $userDAO = new UserDAO();

            foreach ($contentArray as $content) {

                $user = $userDAO->getById($content["user_id"]);

                $owner = $this->LoadData($content);

                $user->setType_data($owner);

                array_push($this->ownerList, $user);

                //guardianList es una lista de Usuarios con Type_data de Guardianes
            }
        }
    }


    public function LoadData($resultSet)
    {
        $Owner = new Owner();
        $Owner->setUser_id($resultSet["user_id"]);
        $Owner->setDni($resultSet["dni"]);

        return $Owner;
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->ownerList as $user) {

            $owner = $user->getType_data();

            $valuesArray = array();
            $valuesArray["user_id"] = $user->getId();
            $valuesArray["dni"] = $owner->getDni();

            array_push($arrayToEncode, $valuesArray);
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }
}
