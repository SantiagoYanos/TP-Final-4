<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;


class GuardianController
{
    public function HomeGuardian()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        echo "<script>console.log('Debug Objects: " . var_dump($_SESSION) . "' );</script>";

        $guardian_DAO = new GuardianDAO();

        $user = $guardian_DAO->GetByEmail($_SESSION["email"]);

        require_once VIEWS_PATH . "home_guardian.php";
    }
}
