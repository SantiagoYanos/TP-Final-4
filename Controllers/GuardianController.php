<?php

namespace Controllers;

//use DAO\GuardianDAO as GuardianDAO;
use  SQLDAO\GuardianDAO as GuardianDAO;
use Models\User as User;
use Models\Guardian as Guardian;
use SQLDAO\ReservationDAO;
use SQLDAO\OwnerDAO as OwnerDAO;
use \Exception as Exception;

class GuardianController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        if ($_SESSION["type"] == "owner") {
            header("location: " . FRONT_ROOT . "Owner/HomeOwner");
        }
    }

    public function HomeGuardian($alert = null)
    {
        try {
            //var_dump($_SESSION);

            $user = new GuardianDAO();

            $user = $user->GetByid($_SESSION["id"]);

            require_once VIEWS_PATH . "home_guardian.php";
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    /*public function updateAvDates($monday = null, $tuesday = null, $wednesday = null, $thursday = null, $friday = null, $saturday = null, $sunday = null)
    {
        $guardian_DAO = new GuardianDAO();

        $guardian_DAO->UpdateAvailableDates($_SESSION["email"], $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
        header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
    }*/

    public function updateAvDates($stringDates)
    {
        try {
            $guardian_DAO = new GuardianDAO();

            if ($stringDates != "") {
                $arrayDates = explode(",", $stringDates);
                $guardian_DAO->AddAvailableDates($_SESSION["id"], $arrayDates);
            } else {
                $guardian_DAO->AddAvailableDates($_SESSION["id"], []);
            }

            header("location: " . FRONT_ROOT . 'Guardian/HomeGuardian?alert=' . "Available dates updated succesfully!");
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function ShowEdit()
    {
        try {
            $user = new GuardianDAO();

            $user = $user->GetByid($_SESSION["id"]);

            require_once VIEWS_PATH . "edit_guardian.php";
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function Edit($preferred_size, $preferred_size_cat, $price = null, $birth_date = null, $cuil = null,  $name = null, $last_name = null, $adress = null, $phone = null)
    {
        try {
            $guardianDAO = new GuardianDAO();

            $user = new User();

            $user->setId($_SESSION["id"]);

            $user->setName($name);

            $user->setLast_name($last_name);

            $user->setAdress($adress);

            $user->setPhone($phone);

            $user->setBirth_date($birth_date);


            $guardian = new Guardian();

            $guardian->setPreferred_size($preferred_size);

            $guardian->setPreferred_size_cat($preferred_size_cat);

            $guardian->setCuil($cuil);

            $guardian->setPrice($price);

            $guardianDAO->Edit($user, $guardian);

            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function ViewReservations($alert = null)
    {
        try {

            $reservationDAO = new ReservationDAO();

            $reservations = $reservationDAO->GetByGuardianOrOwner($_SESSION["id"], "guardian");

            require_once VIEWS_PATH . "guardian_reservationsList.php";
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    function ViewOwnerProfile($owner_id)
    {
        try {
            $ownerDAO = new OwnerDAO();

            $owner = $ownerDAO->GetById($owner_id);

            if ($owner) {
                require_once VIEWS_PATH . "guardian_OwnerProfile.php";
            } else {
                header("location: " . FRONT_ROOT . "Guardian/ViewReservations");
            }
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }
}
