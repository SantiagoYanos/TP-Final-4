<?php

namespace Controllers;

use DAO\PetDAO as PetDAO;
use Models\Pet as Pet;


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

    public function Add($name, $breed, $observation, $pet_size, $vaccination_note, $photo_video){
        $pet = new Pet();

        $pet->setName($name);
        $pet->setBreed($breed);
        $pet->setObservation($observation);
        $pet->setSize($pet_size);
        $pet->setVaccination_plan($vaccination_note);
        $pet->setGuardian_email($_SESSION["email"]);
        //$pet->setPhoto_video($photo_video);

        $petDAO = new PetDAO();

        $petDAO->Add($pet);

        require_once VIEWS_PATH . "home_owner.php";
    }

    public function ShowRegisterPet(){
        require_once VIEWS_PATH . "register_pet.php";
    }
}
