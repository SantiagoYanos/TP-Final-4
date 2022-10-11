<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;

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
        var_dump($_SESSION);

        $guardian_DAO = new GuardianDAO();

        $user = $guardian_DAO->GetByEmail($_SESSION["email"]);

        require_once VIEWS_PATH . "home_guardian.php";
    }

    public function updateAvDates($monday=null, $tuesday=null,$wednesday=null,$thursday=null,$friday=null,$saturday=null,$sunday=null)
    {
        $guardian_DAO= new GuardianDAO();

        $guardian_DAO->UpdateAvailableDates($_SESSION["email"],$monday, $tuesday,$wednesday,$thursday,$friday,$saturday,$sunday);
        header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
    }
    
}
