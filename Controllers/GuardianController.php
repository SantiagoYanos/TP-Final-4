<?php

namespace Controllers;

//use DAO\GuardianDAO as GuardianDAO;
use  SQLDAO\GuardianDAO as GuardianDAO;
use SQLDAO\UserDAO as userDAO;

class GuardianController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        if ($_SESSION["type"] == "owner") {
            header("location: " . FRONT_ROOT . "Owner/HomeOwner");
        }
    }

    public function HomeGuardian()
    {
        //var_dump($_SESSION);

        $userDAO = new userDAO();

        $user = $userDAO->GetByEmail($_SESSION["email"]);

        require_once VIEWS_PATH . "home_guardian.php";
    }

    /*public function updateAvDates($monday = null, $tuesday = null, $wednesday = null, $thursday = null, $friday = null, $saturday = null, $sunday = null)
    {
        $guardian_DAO = new GuardianDAO();

        $guardian_DAO->UpdateAvailableDates($_SESSION["email"], $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
        header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
    }*/

    /*public function updateAvDates($stringDates)
    {

        $guardian_DAO = new GuardianDAO();

        $arrayDates = explode(",", $stringDates);

        $guardian_DAO->UpdateAvailableDates($_SESSION["email"], $arrayDates);

        header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
    }*/

    
}
