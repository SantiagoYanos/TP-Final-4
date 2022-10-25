<?php

namespace Controllers;

use DAO\OwnerDAO as OwnerDAO;
use DAO\GuardianDAO as GuardianDAO;

class OwnerController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }
    }

    public function HomeOwner()
    {
        $owner_DAO = new OwnerDAO();

        $user = $owner_DAO->GetByEmail($_SESSION["email"]);

        require_once VIEWS_PATH . "home_owner.php";
    }

    public function SearchGuardian($name = null, $rating = null, $preferred_size = null, $preferred_size_cat = null, $location = null, $price = null, $monday = null, $tuesday = null, $wednesday = null, $thursday = null, $friday = null, $saturday = null, $sunday = null)
    {
        echo $name;

        $guardian_DAO = new GuardianDAO();

        $guardians = $guardian_DAO->GetAll();

        $guardians = array_filter($guardians, function ($guardian) {

            return $guardian->getPrice() != null;
        });

        $valuesArray = array();
        $valuesArray["monday"] = $monday;
        $valuesArray["tuesday"] = $tuesday;
        $valuesArray["wednesday"] = $wednesday;
        $valuesArray["thursday"] = $thursday;
        $valuesArray["friday"] = $friday;
        $valuesArray["saturday"] = $saturday;
        $valuesArray["sunday"] = $sunday;

        //---------------------------------------------- Filtros de guardianes

        if ($name != null) {
            $guardians = array_filter($guardians, function ($guardian) use ($name) {

                return str_starts_with($guardian->GetName(), $name);
            });
        };

        if ($rating != null) {

            $guardians = array_filter($guardians, function ($guardian) use ($rating) {

                return $guardian->GetReputation() >= $rating;
            });
        }

        if ($preferred_size != null && $preferred_size != "*") {

            $guardians = array_filter($guardians, function ($guardian) use ($preferred_size) {

                return $guardian->GetPreferred_size() == $preferred_size;
            });
        }

        
        if ($preferred_size_cat != null && $preferred_size_cat != "*") {

            $guardians = array_filter($guardians, function ($guardian) use ($preferred_size_cat) {

                return $guardian->GetPreferred_size_cat() == $preferred_size_cat;
            });
        }

        if ($location != null) {

            $guardians = array_filter($guardians, function ($guardian) use ($location) {

                return str_starts_with($guardian->GetAdress(), $location);
            });
        }

        if ($price != null) {

            $guardians = array_filter($guardians, function ($guardian) use ($price) {

                return $guardian->GetPrice() <= $price;
            });
        }

        $guardians = array_filter($guardians, function ($guardian) use ($valuesArray) {

            $valid = true;

            $available_dates = $guardian->getAvailable_date();

            foreach (array_keys($available_dates) as $day) {
                if ($valuesArray[$day] === "on" && $available_dates[$day] === null) {
                    $valid = false;
                }
            }

            return $valid;
        });



        require_once VIEWS_PATH . "guardianList.php";
    }
}
