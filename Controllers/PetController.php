<?php

namespace Controllers;
//use DAO\PetDAO as PetDAO;
use SQLDAO\PetDAO as PetDAO;
use Models\Pet as Pet;
use \Exception as Exception;


class PetController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
        require_once(ROOT . "/Utils/encrypt.php");

        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }
    }

    public function PetList()
    {
        try {

            $pet_DAO = new PetDAO();

            $petList = $pet_DAO->GetPetsByOwner($_SESSION["id"]);

            foreach ($petList as $pet) {

                switch ($pet->getSize()) {
                    case 1:
                        $pet->setSize("Big");
                        break;
                    case 2:
                        $pet->setSize("Medium");
                        break;
                    case 3:
                        $pet->setSize("Small");
                        break;
                }
            }

            require_once VIEWS_PATH . "view_pets.php";
        } catch (Exception $ex) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function Add($name, $breed, $observation, $pet_size, $type, $file, $file1, $pet_video)
    {
        try {

            $fileName = $file["name"];
            $tempFileName = $file["tmp_name"];
            $type1 = $file["type"];

            $filePath = VIEWS_PATH . basename($fileName);
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            $imageSize = getimagesize($tempFileName);

            $fileName1 = $file1["name"];
            $tempFileName1 = $file1["tmp_name"];
            $type1 = $file1["type"];

            $filePath1 = VIEWS_PATH . basename($fileName1);
            $fileType1 = strtolower(pathinfo($filePath1, PATHINFO_EXTENSION));

            $imageSize1 = getimagesize($tempFileName1);


            if ($imageSize !== false && $imageSize1 !== false) {
                if ($imageSize !== false && $imageSize1 !== false) {

                    $pet = new Pet();
                    $pet->setName($name);
                    $pet->setBreed($breed);
                    $pet->setObservation($observation);
                    $pet->setSize($pet_size);

                    $pet->setOwner_id($_SESSION["id"]);
                    $pet->setType($type);
                    $pet->setVaccination_plan($fileName);
                    $pet->setPet_img($fileName1);
                    $pet->setPet_video($pet_video);

                    $message = "Imagen subida correctamente";
                    $petDAO = new PetDAO();

                    $pet_id = $petDAO->Add($pet);

                    if ($pet_id) {
                        mkdir(IMG_PATH . $pet_id);
                        move_uploaded_file($tempFileName, IMG_PATH . $pet_id . "/" . basename($filePath));
                        move_uploaded_file($tempFileName1, IMG_PATH . $pet_id . "/" . basename($filePath1));
                    }
                } else
                    $message = "Ocurrió un error al intentar subir la imagen";
            } else

                $message = "El archivo no corresponde a una imágen";

            return header("location: " . FRONT_ROOT . "Owner/HomeOwner");
        } catch (Exception $ex) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }


    public function deletePet($petId) //Encripted
    {
        try {

            $petId = decrypt($petId);

            $petId ? null : throw new Exception("Pet not found");

            $petDAO = new PetDAO();
            $petDAO->Remove($petId);
            return header("location: " . FRONT_ROOT . "Pet/PetList");
        } catch (Exception $ex) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }


    public function ShowRegisterPet()
    {
        require_once VIEWS_PATH . "register_pet.php";
    }
}
