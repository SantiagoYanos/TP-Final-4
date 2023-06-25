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

    public function MakeReservation($guardian_id, $reservation_dates = null, $pets_ids = [])
    {
        //Seleccionar Pets
        //Seleccionar Fechas
        //Las Pets seleccionadas deben tener la misma raza. (El tamaño puede variar). LISTO
        //El Guardian debe poder soportar los tamaños de las mascotas. LISTO
        //Check Fechas disponibles para el guardian (Fechas válidas). LISTO
        //No se puede hacer el mismo pedido de reserva 2 veces. LISTO 

        //Si el usuario es un guardian se redirige al inicio... (Sólo un Owner puede hacer una reserva)
        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }

        $flag = 0;

        //Si no se seleccionó ninguna mascota...
        if ($pets_ids == []) {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more pets!"');
        }

        //Si no se seleccionó una fecha...
        if (!$reservation_dates || $reservation_dates == "") {
            header("location: "  . FRONT_ROOT . "Owner/ViewGuardianProfile?guardian_id=" . $guardian_id . '&alert="You need to select one or more dates!"');
        }

        $reservation_dates_array = explode(",", $reservation_dates);

        try {

            $PetDAO = new PetDAO();
            $guardianDAO = new GuardianDAO();
            $reservationDAO = new ReservationDAO;

            //-------------- Chequeo existencia del Guardia ------------------------

            $guardian_id = decrypt($guardian_id);

            $guardian_id ? null : throw new GuardianNotFoundException();

            $guardian_user = $guardianDAO->GetById($guardian_id);

            //------------- Chequear que las fechas seleccionadas sean válidas (Permitidas por el Guardián) --------------------

            $available_dates = $guardianDAO->GetAvailableDates($guardian_id);

            $checkDates = array_diff($reservation_dates_array, $available_dates);

            if (sizeof($checkDates) > 0) {
                $flag = 4;
            }

            //------------- Chequear si el guardian ya tiene una reserva con esas pets seleccionadas -------------

            //Desencriptar las ids de pets...

            $pets_ids = array_map(function ($petId) {
                $decryptedPet = decrypt($petId);

                $decryptedPet ? null : throw new PetNotFoundException();

                return $decryptedPet;
            }, $pets_ids);

            //Obtiene las Ids de las mascotas ya reservadas en las fechas seleccionadas
            $petsReservedIds = $reservationDAO->getPetsIdsPendingByDates($guardian_id, $reservation_dates_array);

            //Chequeo de Ids repetidas

            //Si se detectaron mascotas reservadas en esos días...
            if ($petsReservedIds) {
                //Se chequea si alguna de las mascotas reservadas es la misma que alguna de las seleccionadas
                $checkRepeat = array_diff($pets_ids, $petsReservedIds);

                //Si no se retornaron la misma cantidad de pets diferentes... (Significa que almenos una sí está reservada en estos días)
                if (sizeof($checkRepeat) != sizeof($pets_ids)) {
                    $flag = 2;
                }
            }

            //------------------------------------------------------------------------------------------------------

            ///// ----------------- Chequear size de las Pets -------------------------------------

            //Checkeo que los tamaños de las pets sean soportadas por el guardian

            require_once(ROOT . "/Utils/selectSize.php");

            $guardianPetSizeDog = $petSizesEnum[$guardian_user->getType_Data()->getPreferred_size()];
            $guardianPetSizeCat = $petSizesEnum[$guardian_user->getType_Data()->getPreferred_size_Cat()];

            $petList = array();

            foreach ($pets_ids as $pet_id) {

                $pet = $PetDAO->GetById($pet_id);

                array_push($petList, $pet);

                switch ($pet->getType()) {
                    case "dog":
                        if ($guardianPetSizeDog > $pet->getSize()) {
                            $flag = 1;
                        }
                        break;
                    case "cat":
                        if ($guardianPetSizeCat > $pet->getSize()) {
                            $flag = 1;
                        }
                        break;
                }
            }

            //-----------------------------------------------------------------------------------

            //---------------------- Checkeo de que todas las mascotas son de la misma raza... ----------------------------

            if (!$this->checkBreed($petList)) {
                $flag = 3;
            }

            //-------------------------------------------------------------------------------------------------------------

            //------------------------- Redirección final ------------------------------

            switch ($flag) {

                case 0:

                    //Creación de la reserva
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

                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="This pet has already been requested to this Guardian at those dates!"');

                    break;

                case 3:

                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="You cant add two different breeds into one reservation!"');

                    break;

                case 4:

                    header("location: " . FRONT_ROOT . 'Owner/SearchGuardian?name=&rating=&preferred_size=*&preferred_size_cat=*&location=&price=&stringDates=&alert="Dates not available!"');

                    break;
            }

            //---------------------------------------------------------------------------

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
        //Las Fechas deben estár incluidas en las fechas disponibles del Guardian. - LISTO (Al realizar una reserva)
        //Check raza de mascotas en las reservas ya aceptadas por el guardian. - LISTO
        //Check de Fechas (Si ya tiene una reserva en alguna de las fechas, la raza de las mascotas debe coincidir). - LISTO

        try {
            if ($_SESSION["type"] == "owner") {
                header("location: " . FRONT_ROOT . "Owner/HomeOwner");
            }

            //------- Check existencia de la reserva a aceptar ----------

            $reservationDAO = new ReservationDAO;

            $reservation_id = decrypt($reservation_id);

            $reservation_id ? null : throw new ReservationNotFoundException();

            $reservation = $reservationDAO->getById($reservation_id);

            //-----------------------------------------------------------

            $owner_DAO = new OwnerDAO();
            $user = new User();
            $user = $owner_DAO->GetById($reservation->getOwner_id());
            $payment = new PaymentController();
            $pet_DAO = new PetDAO();

            $reservation_DAO = new ReservationDAO();

            $reservedPets = $reservation_DAO->getPetsReservedByDates($reservation->getGuardian_id(), $reservation->getDates());

            //$pet = $reservationDAO->getExistingReservations($reservation->getDates());

            if ($reservedPets && $reservedPets[0]) {

                $petList = array();

                foreach ($reservedPets as $reservedPet) {
                    array_push($petList, $reservedPet);
                }

                //Agrega a un array la mascota de las reservas ya existentes - Múltiples mascotas

                //Agrega al array la primer mascota de nuestra nueva Reserva que queremos hacer
                array_push($petList, $reservation->getPets()[0]);

                //Chequea si las mascotas son de la misma raza y tipo.
                if ($this->checkBreed($petList) != true) {
                    header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&rejected=&canceled=&alert="Reservation cannot be accepted!! \n(Pets with different breeds already accepted)"');
                } else {
                    $reservationDAO->updateState($reservation->getId(), "Payment pending");

                    ////Mandar Cupon////
                    $payment->SendEmailCoupon($user->getEmail(), $reservation_id);

                    header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&rejected=&canceled=&alert="Reservation accepted"');
                }
            } else {

                //No se encontraron mascotas ya reservadas en las fechas pedidas.
                $reservationDAO->updateState($reservation->getId(), "Payment pending");

                ////Mandar Cupon////
                $payment->SendEmailCoupon($user->getEmail(), $reservation_id);

                header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&rejected=&canceled=&alert="Reservation accepted"');
            }
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function rejectReservation($reservation_id)
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
                header("location: " . FRONT_ROOT . 'Guardian/ViewReservations?state=&rejected=&canceled=&alert="Reservation rejected"');
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
                header("location: " . FRONT_ROOT . 'Owner/ViewReservationsOwner?state=&rejected=&canceled=&alert="Reservation canceled"');
            }
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function checkBreed($petList)
    {
        try {

            $breed = $petList[0]->getBreed();
            $type = $petList[0]->getType();

            $result = true;

            foreach ($petList as $pet) {
                if ($pet->getBreed() != $breed || $pet->getType() != $type) {
                    $result = false;
                }
            }
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
