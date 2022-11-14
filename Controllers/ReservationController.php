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

        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }
        $flag=0;

        if ($pets_ids == []) {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more pets!"');
        }

        if (!$reservation_dates) {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more dates!"');
        }

        $reservationDAO = new ReservationDAO;

        $reservation_dates_array = explode(",", $reservation_dates);

        $reservationList = $reservationDAO->GetAllByDates($guardian_id, $reservation_dates_array);

        foreach($reservationList as $reservation){
            foreach($reservation->getPets() as $pet){
                foreach($pets_ids as $pet_id){
                    if($pet->getId() == $pet_id){
                        $flag=2;
                    }
                }
            }
        }
        
        /////Chequear size
        $PetDAO = new PetDAO();
        $guardianDAO = new GuardianDAO();
        $owner_DAO = new OwnerDAO();
        $guardian_user = $guardianDAO->GetById($guardian_id);

        $guardianPetSize=$guardian_user->getType_Data()->getPreferred_size();
        $guardianPetSizeCat=$guardian_user->getType_Data()->getPreferred_size_Cat();

        if($guardianPetSizeCat=="big"){
            $guardianPetSizeCat=1;
        }
        if($guardianPetSizeCat=="medium"){
            $guardianPetSizeCat=2;
        }
        if($guardianPetSizeCat=="small"){
            $guardianPetSizeCat=3;
        }
        if($guardianPetSize=="big"){
            $guardianPetSize=1;
        }
        if($guardianPetSize=="medium"){
            $guardianPetSize=2;
        }
        if($guardianPetSize=="small"){
            $guardianPetSize=3;
        }

        $petList=array();

        foreach($pets_ids as $pet_id){
            
            $pet = $PetDAO->GetById($pet_id);
            array_push($petList,$pet);
            if($pet->getType() == "dog"){
                if($guardianPetSize > $pet->getSize()){
                    $flag=1;
                }
            }
            if($pet->getType()=="cat"){
                if($guardianPetSizeCat > $pet->getSize()){
                    $flag=1;
                }
            }  
        }

        if($this->checkBreed($petList)!=true){

            $flag=1;
        }    
        
        if($flag!=1 && $flag!=2){
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
            if($flag==1){
                header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="The Guardian does not support that pet size!"');
            }
            else{
                header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="This pet has already been requested to this Guardian at that date!"');
            }
        }
    }

    public function acceptReservation($reservation_id) {
        if ($_SESSION["type"] == "owner") {
            header("location: " . FRONT_ROOT . "Owner/HomeOwner");
        }
       
        $flag=0;

        $reservationDAO= new ReservationDAO;
        $reservation=$reservationDAO->getById($reservation_id);
        
        
        $pet=$reservationDAO->getExistingReservations($reservation->getDates());
        if($pet)
        {
            
            $petList=array();
            array_push($petList,$pet);
            array_push($petList,$reservation->getPets()[0]);
            

            //var_dump($pet);
            

            if($this->checkBreed($petList)!=true){

                header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?alert="reservation cannot be accepted"');

            }else{
                $reservationDAO->updateState($reservation->getId(),"Accepted");
                header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?alert="reservation accepted"');
            }

        }else{

            $reservationDAO->updateState($reservation->getId(),"Accepted");

            header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?alert="reservation accepted"');

        }
    }

    public function checkBreed($petList) {

        $breed=$petList[0]->getBreed();
        $type=$petList[0]->getType();

        foreach ($petList as $pet) {
            /*var_dump($pet->getBreed());
            var_dump($petList[1]);
            var_dump($petList[1]->getBreed());*/
            if($pet->getBreed() != $breed || $pet->getType()!= $type)
            {
                return false;
            }

        }
        return true;

    }

    public function rejectReservation($reservation_id)
    {

        $reservationDAO= new ReservationDAO;
        $reservation=$reservationDAO->getById($reservation_id);

        $reservationDAO->updateState($reservation->getId(),"Rejected");

            header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?alert="reservation rejected"');

    }
}
