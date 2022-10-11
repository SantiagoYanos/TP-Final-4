<?php

namespace Controllers;

use DAO\PetDAO as PetDAO;


class PetController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }
    }

    public function PetList()
    {

        echo "<script>console.log('Debug Objects: " . var_dump($_SESSION) . "' );</script>";

        $pet_DAO = new PetDAO();

        $petList = $pet_DAO->GetPetsByOwner($_SESSION["email"]);

        require_once VIEWS_PATH . "view_pets.php";
    }
}
