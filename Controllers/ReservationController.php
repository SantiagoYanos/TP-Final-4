<?php

namespace Controllers;

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

    public function SeeProfile($guardian_id){
        $guardianDAO = new GuardianDAO();
        $petDAO = new PetDAO();

        $petList = $petDAO->GetPetsByOwner($_SESSION["id"]);

        $guardian = $guardianDAO->GetById($_POST["guardian_id"]);
        require_once(VIEWS_PATH . "owner_GuardianProfile.php");
    }

    public function MakeReservation($guardian_id, $reservation_dates, $pets_ids)
    {
        $owner_DAO = new OwnerDAO();
        $guardianDAO = new GuardianDAO();
        $guardian_user = $guardianDAO->GetById($guardian_id);

        $cant_pets=0;

        foreach($_SESSION["pet_name"] as $pet){
            $cant_pets++;
        }

        $price = $cant_pets * $guardian_user->getType_data()->getPrice();

        $reservation = new Reservation();
        $reservation->setGuardian_id($guardian_id);
        $reservation->setOwner_id($_SESSION["id"]);
        $reservation->setPrice($price);

        var_dump($reservation);

        /* $reservation_dates = String de fechas (Lo que nos da el calendario) */

        /* $pets_ids = Array de Id's de las mascotas a agregar en la reserva (Hay que ver como hacerlo)*/

        $reservation_dates = explode(",", $reservation_dates);

        $reservation_DAO = new ReservationDAO();
        $reservation_DAO->Add($reservation, ["2022-10-02", "2021-05-01"], [1]); //Cambiar los valores de prueba;

        require_once VIEWS_PATH . "make_reservation.php";
    }
}
