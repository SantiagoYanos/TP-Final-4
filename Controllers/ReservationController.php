<?php 
namespace Controllers;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\GuardianDAO as GuardianDAO;
USE SQLDAO\OwnerDAO as OwnerDAO;
use Models\Reservation as Reservation;

class ReservationController{

    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }
    }

    public function MakeReservation($guardian_id){
        $guardian_DAO = new GuardianDAO();
        $owner_DAO = new OwnerDAO();

        $user_guardian = $guardian_DAO->GetById(1);

        $reservation = new Reservation();
        $reservation->setGuardian_id(1);
        $reservation->setPrice(500);
        
        $reservation_DAO = new ReservationDAO();
        $reservation_DAO->Add($reservation, $user_guardian->getType_data());

        require_once VIEWS_PATH . "make_reservation.php";
    }

}
?>