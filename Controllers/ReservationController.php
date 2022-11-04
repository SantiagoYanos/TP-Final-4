<?php

namespace Controllers;

use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\GuardianDAO as GuardianDAO;
use SQLDAO\OwnerDAO as OwnerDAO;
use Models\Reservation as Reservation;

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

        $reservation_dates = join(",", $reservation_dates);

        $reservation_DAO = new ReservationDAO();
        $reservation_DAO->Add($reservation, $reservation_dates, $pets_ids);

        require_once VIEWS_PATH . "make_reservation.php";
    }
}
