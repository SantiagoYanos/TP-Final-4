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

    public function SearchGuardian($name = null, $rating = null, $preferred_size = null, $preferred_size_cat = null, $location = null, $price = null, $stringDates = null)
    {

        $guardian_DAO = new GuardianDAO();

        $guardians = $guardian_DAO->GetAll();

        $guardians = array_filter($guardians, function ($guardian) {

            return $guardian->getPrice() != null;
        });

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

        if ($stringDates != null) {
            $guardians = array_filter($guardians, function ($guardian) use ($price) {

                return $guardian->GetPrice() <= $price;
            });
        }

        $stringDates = explode(",", $stringDates);

        $queryDates = join("' OR '", $stringDates);

        $query = "SELECT * FROM available_dates WHERE '" . $queryDates . "';";

        require_once VIEWS_PATH . "guardianList.php";
    }
}
