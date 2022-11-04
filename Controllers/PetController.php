<?php

namespace Controllers;

use SQLDAO\PetDAO as PetDAO;
use Models\Pet as Pet;
use \Exception as Exception;


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

        // echo "<script>console.log('Debug Objects: " . var_dump($_SESSION) . "' );</script>";

        $pet_DAO = new PetDAO();

        $petList = $pet_DAO->GetPetsByOwner($_SESSION["id"]);
        //acordarse de en la vista usar un if para mostrar el tamaño como texto en lugar de numero
        require_once VIEWS_PATH . "view_pets.php";
    }

    public function Add($name, $breed, $observation, $pet_size, $type, $file, $file1, $pet_video)
    {
        try
        {
            
            echo "--------------";
            $fileName = $file["name"];
            $tempFileName = $file["tmp_name"];
            $type = $file["type"];
            
            $filePath = VIEWS_PATH.basename($fileName);            
            echo "*********";
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            $imageSize = getimagesize($tempFileName);


            echo "--------------";
            $fileName1 = $file1["name"];
            $tempFileName1 = $file1["tmp_name"];
            $type1 = $file1["type"];
            
            $filePath1 = VIEWS_PATH.basename($fileName1);            
            echo "*********";
            $fileType1 = strtolower(pathinfo($filePath1, PATHINFO_EXTENSION));

            $imageSize1 = getimagesize($tempFileName1);

            
            if($imageSize !== false && $imageSize1 !==false)
            {
                if (move_uploaded_file($tempFileName, $filePath))
                {
        
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

                    $petDAO->Add($pet);
                }
                else
                    $message = "Ocurrió un error al intentar subir la imagen";
            }
            else   
                $message = "El archivo no corresponde a una imágen";
        }
        catch(Exception $ex)
        {
            $message = $ex->getMessage();
        }
      
    


        return header("location: " . FRONT_ROOT . "Owner/HomeOwner");
    }

    public function ShowRegisterPet()
    {
        require_once VIEWS_PATH . "register_pet.php";
    }




}


    


