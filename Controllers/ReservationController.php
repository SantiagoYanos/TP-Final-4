<?php

namespace Controllers;



use Models\Reservation as Reservation;
use Models\Pet as Pet;
use SQLDAO\PetDAO;
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

    public function MakeReservation($guardian_id, $price, $reservation_dates, $pets_ids)
    {
        $owner_DAO = new OwnerDAO();

        $reservation = new Reservation();
        $reservation->setGuardian_id(1);
        $reservation->setPrice(500);

        /* $reservation_dates = String de fechas (Lo que nos da el calendario) */

        /* $pets_ids = Array de Id's de las mascotas a agregar en la reserva (Hay que ver como hacerlo)*/

        $reservation_dates = explode(",", $reservation_dates);

        $reservation_DAO = new ReservationDAO();
        $reservation_DAO->Add($reservation, ["2022-10-02", "2021-05-01"], [1]); //Cambiar los valores de prueba;

        require_once VIEWS_PATH . "make_reservation.php";
    }
}
