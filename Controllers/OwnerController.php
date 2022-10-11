<?php

namespace Controllers;

use DAO\OwnerDAO as OwnerDAO;

class OwnerController
{
    public function HomeOwner()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        $owner_DAO = new OwnerDAO();

        $user = $owner_DAO->GetByEmail($_SESSION["email"]);

        require_once VIEWS_PATH . "home_owner.php";
    }
}
