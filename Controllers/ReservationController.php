<?php

namespace Controllers;

use Models\Guardian;
use Models\Reservation as Reservation;
use Models\Pet as Pet;
use SQLDAO\PetDAO as PetDAO;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\GuardianDAO as GuardianDAO;
use SQLDAO\OwnerDAO as OwnerDAO;

class ReservationController
{

    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }
    }

    /*public function SeeProfile($guardian_id){
        $guardianDAO = new GuardianDAO();
        $petDAO = new PetDAO();

        $petList = $petDAO->GetPetsByOwner($_SESSION["id"]);

        $guardian = $guardianDAO->GetById($_POST["guardian_id"]);
        require_once(VIEWS_PATH . "owner_GuardianProfile.php");
    }*/

    public function MakeReservation($guardian_id, $reservation_dates = null, $pets_ids = [])
    {
        $flag=0;

        if ($pets_ids == []) {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more pets!"');
        }

        if (!$reservation_dates) {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more dates!"');
        }

        /////Chequear size
        $PetDAO = new PetDAO();
        $guardianDAO = new GuardianDAO();
        $owner_DAO = new OwnerDAO();
        $guardian_user = $guardianDAO->GetById($guardian_id);

        foreach($pets_ids as $pet_id){
    
            $pet = $PetDAO->GetById($pet_id);
            if($pet->getType() == "dog"){
                if($guardian_user->getType_data()->getPreferred_size() >= $pet->getSize()){
                    $flag=1;
                }
            }
            if($pet->getType()=="cat"){
                if($guardian_user->getType_data()->getPreferred_size_cat() >= $pet->getSize()){
                    $flag=1;
                }
            }  
        }
                        
        
        if($flag==0){
                $cant_pets = 0;
        
                foreach ($pets_ids as $pet) {
                    $cant_pets++;
                }
        
                $price = $cant_pets * $guardian_user->getType_data()->getPrice();
        
                $reservation = new Reservation();
                $reservation->setGuardian_id($guardian_id);
                $reservation->setOwner_id($_SESSION["id"]);
                $reservation->setPrice($price);
        
                /*var_dump($_POST);*/
        
                $reservation_dates = explode(",", $reservation_dates);
        
                $reservation_DAO = new ReservationDAO();
                $reservation_DAO->Add($reservation, $reservation_dates, $pets_ids); //Cambiar los valores de prueba;
        
                /*var_dump($reservation);*/
        
                header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="Reservation request sent to Guardian!"');
        }
        else{
            header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="The Guardian does not support that pet size!"');
        }
    }
}
