<?php

namespace Controllers;

use DAO\OwnerDAO as OwnerDAO;

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
}
