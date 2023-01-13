<?php

namespace Controllers;

use Exception;
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
        $flag = 0;

        if ($pets_ids == []) {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more pets!"');
        }

        if (!$reservation_dates || $reservation_dates == "") {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more dates!"');
        }

        $reservationDAO = new ReservationDAO;

        $reservation_dates_array = explode(",", $reservation_dates);

        $reservationList = $reservationDAO->GetAllByDates($guardian_id, $reservation_dates_array);

        //Saber si ya hay una reserva con esa pet;

        foreach ($reservationList as $reservation) {
            foreach ($reservation->getPets() as $pet) {
                foreach ($pets_ids as $pet_id) {
                    if ($pet->getId() == $pet_id) {
                        $flag = 2;
                        break 3;
                    }
                }
            }
        }

        try {
            /////Chequear size
            $PetDAO = new PetDAO();
            $guardianDAO = new GuardianDAO();
            //$owner_DAO = new OwnerDAO();
            $guardian_user = $guardianDAO->GetById($guardian_id);

            // $guardianPetSize = $guardian_user->getType_Data()->getPreferred_size();
            // $guardianPetSizeCat = $guardian_user->getType_Data()->getPreferred_size_Cat();

            $petSizesEnum = array(
                "big" => 1,
                "medium" => 2,
                "small" => 3
            );

            $guardianPetSize = $petSizesEnum[$guardian_user->getType_Data()->getPreferred_size()];
            $guardianPetSizeCat = $petSizesEnum[$guardian_user->getType_Data()->getPreferred_size_Cat()];


            // if ($guardianPetSizeCat == "big") {
            //     $guardianPetSizeCat = 1;
            // }
            // if ($guardianPetSizeCat == "medium") {
            //     $guardianPetSizeCat = 2;
            // }
            // if ($guardianPetSizeCat == "small") {
            //     $guardianPetSizeCat = 3;
            // }
            // if ($guardianPetSize == "big") {
            //     $guardianPetSize = 1;
            // }
            // if ($guardianPetSize == "medium") {
            //     $guardianPetSize = 2;
            // }
            // if ($guardianPetSize == "small") {
            //     $guardianPetSize = 3;
            // }

            $petList = array();

            foreach ($pets_ids as $pet_id) {

                $pet = $PetDAO->GetById($pet_id);
                array_push($petList, $pet);
                if ($pet->getType() == "dog") {
                    if ($guardianPetSize > $pet->getSize()) {
                        $flag = 1;
                    }
                }
                if ($pet->getType() == "cat") {
                    if ($guardianPetSizeCat > $pet->getSize()) {
                        $flag = 1;
                    }
                }
            }

            if ($this->checkBreed($petList) != true) {
                $flag = 3;
            }

            if ($flag == 0) {

                $price = count($pets_ids) * $guardian_user->getType_data()->getPrice();

                $price = $price * count(explode(",", $reservation_dates));

                $reservation = new Reservation();
                $reservation->setGuardian_id($guardian_id);
                $reservation->setOwner_id($_SESSION["id"]);
                $reservation->setPrice($price);

                $reservation_dates = explode(",", $reservation_dates);

                $reservation_DAO = new ReservationDAO();
                $reservation_DAO->Add($reservation, $reservation_dates, $pets_ids); //Cambiar los valores de prueba;

                header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="Reservation request sent to Guardian!"');
            } else {
                if ($flag == 1) {
                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="The Guardian does not support that pet size!"');
                } else {
                    if ($flag == 2) {
                        header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="This pet has already been requested to this Guardian at that date!"');
                    } else {
                        header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="You cant add two different breeds into one reservation!"');
                    }
                }
            }
        } catch (Exception $ex) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function acceptReservation($reservation_id)
    {
        try {
            if ($_SESSION["type"] == "owner") {
                header("location: " . FRONT_ROOT . "Owner/HomeOwner");
            }

            $flag = 0;

            $reservationDAO = new ReservationDAO;
            $reservation = $reservationDAO->getById($reservation_id);


            $pet = $reservationDAO->getExistingReservations($reservation->getDates());
            if ($pet) {

                $petList = array();
                array_push($petList, $pet);
                array_push($petList, $reservation->getPets()[0]);

                if ($this->checkBreed($petList) != true) {

                    header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&alert="Reservation cannot be accepted!!"');
                } else {
                    $reservationDAO->updateState($reservation->getId(), "Payment pending");
                    header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&alert="Reservation accepted"');
                }
            } else {

                $reservationDAO->updateState($reservation->getId(), "Payment pending");

                header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&alert="Reservation accepted"');
            }
        } catch (Exception $ex) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function checkBreed($petList)
    {

        $breed = $petList[0]->getBreed();
        $type = $petList[0]->getType();

        foreach ($petList as $pet) {
            /*var_dump($pet->getBreed());
            var_dump($petList[1]);
            var_dump($petList[1]->getBreed());*/
            if ($pet->getBreed() != $breed || $pet->getType() != $type) {
                return false;
            }
        }
        return true;
    }

    public function rejectReservation($reservation_id)
    {
        try {
            $reservationDAO = new ReservationDAO;
            $reservation = $reservationDAO->getById($reservation_id);
            $reservationDAO->updateState($reservation->getId(), "Rejected");
            header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&alert="Reservation rejected"');
        } catch (Exception $ex) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }
}
