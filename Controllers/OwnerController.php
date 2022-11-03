<?php

namespace Controllers;

use SQLDAO\OwnerDAO as OwnerDAO;
use SQLDAO\GuardianDAO as GuardianDAO;
use StringBackedEnum;

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

        $user = $owner_DAO->GetById($_SESSION["id"]);

        require_once VIEWS_PATH . "home_owner.php";
    }

    public function MakeReservation(){
        
    }


    public function SearchGuardian($name = null, $rating = null, $preferred_size = null, $preferred_size_cat = null, $location = null, $price = null, $stringDates = null)
    {

        $guardian_DAO = new GuardianDAO();

        $filters = array();

        if ($name != null) {
            array_push($filters, ["name", $name]);
        }

        if ($rating != null) {
            array_push($filters, ["reputation", $rating]);
        }

        if ($preferred_size != null && $preferred_size != "*") {
            array_push($filters, ["preferred_size_dog", $preferred_size]);
        }

        if ($preferred_size_cat != null && $preferred_size_cat != "*") {
            array_push($filters, ["preferred_size_cat", $preferred_size_cat]);
        }

        if ($location != null) {
            array_push($filters, ["adress", $location]);
        }

        if ($price != null) {
            array_push($filters, ["price", $price]);
        }

        if ($stringDates != null && $stringDates != "") {
            $stringDates = explode(",", $stringDates);
        } else {
            $stringDates = [];
        }

        array_push($filters, ["available_dates", $stringDates]);

        if ($filters != []) {
            $guardians = $guardian_DAO->SearchGuardiansByFilters($filters);
        } else {
            $guardians = $guardian_DAO->GetAll();
        }

        //$guardians = $guardian_DAO->GetAll();

        // $guardians = array_filter($guardians, function ($guardian) {

        //     return $guardian->getType_data()->getPrice() != null;
        // });

        // //---------------------------------------------- Filtros de guardianes

        // if ($name != null) {
        //     $guardians = array_filter($guardians, function ($guardian) use ($name) {

        //         return str_starts_with($guardian->GetName(), $name);
        //     });
        // };

        // if ($rating != null) {

        //     $guardians = array_filter($guardians, function ($guardian) use ($rating) {

        //         return $guardian->getType_data()->GetReputation() >= $rating;
        //     });
        // }

        // if ($preferred_size != null && $preferred_size != "*") {

        //     $guardians = array_filter($guardians, function ($guardian) use ($preferred_size) {

        //         return $guardian->getType_data()->GetPreferred_size() == $preferred_size;
        //     });
        // }


        // if ($preferred_size_cat != null && $preferred_size_cat != "*") {

        //     $guardians = array_filter($guardians, function ($guardian) use ($preferred_size_cat) {

        //         return $guardian->getType_data()->GetPreferred_size_cat() == $preferred_size_cat;
        //     });
        // }

        // if ($location != null) {

        //     $guardians = array_filter($guardians, function ($guardian) use ($location) {

        //         return str_starts_with($guardian->GetAdress(), $location);
        //     });
        // }

        // if ($price != null) {

        //     $guardians = array_filter($guardians, function ($guardian) use ($price) {

        //         return $guardian->getType_data()->GetPrice() <= $price;
        //     });
        // }

        // if ($stringDates != null && $stringDates!="") {
        //     $guardians = array_filter($guardians, function ($guardian) use ($price) {

        //         return $guardian->getType_data()->getAvailable_date()
        //     });
        // }

        // if ($stringDates != NULL) {
        //     $stringDates = explode(",", $stringDates);
        // }

        // $queryDates = join("' OR '", $stringDates);

        // $query = "SELECT * FROM available_dates WHERE '" . $queryDates . "';";

        require_once VIEWS_PATH . "guardianList.php";
    }
}
