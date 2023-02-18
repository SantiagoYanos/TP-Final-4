<?php

namespace Controllers;

use Exception;
use Models\Guardian as Guardian;
use Models\Reservation as Reservation;
use Models\Pet as Pet;
use Models\User as User;
use SQLDAO\PetDAO as PetDAO;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\GuardianDAO as GuardianDAO;
use SQLDAO\OwnerDAO as OwnerDAO;
use Controllers\PaymentController as PaymentController;
use DAO\UserDAO as UserDAO;
use PetNotFoundException;
use GuardianNotFoundException;
use ReservationNotFoundException;

class ReservationController
{

    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
        require_once(ROOT . "/Utils/encrypt.php");
        require_once(ROOT . "/Exceptions/PetNotFoundException.php");
        require_once(ROOT . "/Exceptions/GuardianNotFoundException.php");
        require_once(ROOT . "/Exceptions/ReservationNotFoundException.php");
    }

    /*public function SeeProfile($guardian_id){
        $guardianDAO = new GuardianDAO();
        $petDAO = new PetDAO();

        $petList = $petDAO->GetPetsByOwner($_SESSION["id"]);

        $guardian = $guardianDAO->GetById($_POST["guardian_id"]);
        require_once(VIEWS_PATH . "owner_GuardianProfile.php");
    }*/

    public function MakeReservation($guardian_id, $reservation_dates = null, $pets_ids = []) //Encripted
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

        try {

            $reservationList = $reservationDAO->GetAllByDates($guardian_id, $reservation_dates_array);

            //Desencriptar las ids de pets...

            $pets_ids = array_map(function ($petId) {
                $decryptedPet = decrypt($petId);

                $decryptedPet ? null : throw new PetNotFoundException();

                return $decryptedPet;
            }, $pets_ids);

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

            /////Chequear size
            $PetDAO = new PetDAO();
            $guardianDAO = new GuardianDAO();
            //$owner_DAO = new OwnerDAO();

            $guardian_id = decrypt($guardian_id);

            $guardian_id ? null : throw new GuardianNotFoundException();

            $guardian_user = $guardianDAO->GetById($guardian_id);

            // $guardianPetSize = $guardian_user->getType_Data()->getPreferred_size();
            // $guardianPetSizeCat = $guardian_user->getType_Data()->getPreferred_size_Cat();

            require_once(ROOT . "/Utils/selectSize.php");

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

                switch ($pet->getType()) {
                    case "dog":
                        if ($guardianPetSize > $pet->getSize()) {
                            $flag = 1;
                        }
                        break 2;
                    case "cat":
                        if ($guardianPetSizeCat > $pet->getSize()) {
                            $flag = 1;
                        }
                        break 2;
                }
            }

            if ($this->checkBreed($petList) != true) {
                $flag = 3;
            }

            switch ($flag) {
                case 0:

                    $price = count($pets_ids) * $guardian_user->getType_data()->getPrice();

                    $price = $price * count(explode(",", $reservation_dates));

                    $reservation = new Reservation();
                    $reservation->setGuardian_id($guardian_id);
                    $reservation->setOwner_id($_SESSION["id"]);
                    $reservation->setPrice($price);

                    $reservation_dates = explode(",", $reservation_dates);

                    $reservation_DAO = new ReservationDAO();
                    $reservation_DAO->Add($reservation, $reservation_dates, $pets_ids);

                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="Reservation request sent to Guardian!"');

                    break;

                case 1:

                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="The Guardian does not support that pet size!"');

                    break;

                case 2:

                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="This pet has already been requested to this Guardian at that date!"');

                    break;

                case 3:

                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="You cant add two different breeds into one reservation!"');

                    break;
            }
        } catch (PetNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (GuardianNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function acceptReservation($reservation_id) //Encripted
    {
        try {
            if ($_SESSION["type"] == "owner") {
                header("location: " . FRONT_ROOT . "Owner/HomeOwner");
            }

            $reservationDAO = new ReservationDAO;

            $reservation_id = decrypt($reservation_id);

            $reservation_id ? null : throw new ReservationNotFoundException();

            $reservation = $reservationDAO->getById($reservation_id);

            $owner_DAO = new OwnerDAO();
            $user = new User();
            $user = $owner_DAO->GetById($reservation->getOwner_id());

            $payment = new PaymentController();
            $payment->SendEmailCoupon($user->getEmail(), $reservation_id);
            ////Mandar Cupon////

            $pet = $reservationDAO->getExistingReservations($reservation->getDates());

            if ($pet) {

                $petList = array();

                //Agrega a un array la mascota de las reservas ya existentes
                array_push($petList, $pet);

                //Agrega al array la primer mascota de nuestra nueva Reserva que queremos hacer
                array_push($petList, $reservation->getPets()[0]);

                //Chequea si las 2 mascotas son de la misma raza y tipo.
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
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function rejectReservation($reservation_id) //Encripted
    {
        try {

            if ($_SESSION["type"] == "owner") {
                header("location: " . FRONT_ROOT . "Owner/HomeOwner");
            }

            $reservationDAO = new ReservationDAO;

            $reservation_id = decrypt($reservation_id);

            $reservation_id ? null : throw new ReservationNotFoundException();

            $reservation = $reservationDAO->getById($reservation_id);

            if ($reservation->getState() == "Pending") {
                $reservationDAO->updateState($reservation->getId(), "Rejected");
                header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&alert="Reservation rejected"');
            }
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function cancelReservation($reservation_id)
    {
        try {

            if ($_SESSION["type"] == "guardian") {
                header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
            }

            $reservationDAO = new ReservationDAO;

            $reservation_id = decrypt($reservation_id);

            $reservation_id ? null : throw new ReservationNotFoundException();

            $reservation = $reservationDAO->getById($reservation_id);

            $state = $reservation->getState();

            if ($state == "Pending" || $state == "Payment pending") {
                $reservationDAO->updateState($reservation_id, "Canceled");
                header("location: " . FRONT_ROOT . 'Owner/ViewReservationsOwner?state=&alert="Reservation canceled"');
            }
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function checkBreed($petList)
    {

        $breed = $petList[0]->getBreed();
        $type = $petList[0]->getType();

        foreach ($petList as $pet) {
            if ($pet->getBreed() != $breed || $pet->getType() != $type) {
                return false;
            }
        }
        return true;
    }
}
