<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;


class GuardianController
{
    public function HomeGuardian()
    {



        
        session_start();
        require_once(FRONT_ROOT . "/Utils/validateSession.php");

        session_start();

        echo "<script>console.log('Debug Objects: " . var_dump($_SESSION) . "' );</script>";

        $guardian_DAO = new GuardianDAO();

        $user = $guardian_DAO->GetByEmail($_SESSION["email"]);

        require_once VIEWS_PATH . "home_guardian.php";
    }
}
