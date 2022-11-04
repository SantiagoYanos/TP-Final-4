<?php 
namespace Controllers;

use Models\Pet;
use Models\Reservation as Reservation;
use Models\Pets as Pets;
use SQLDAO\PetDAO;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\GuardianDAO as GuardianDAO;
USE SQLDAO\OwnerDAO as OwnerDAO;

class ReservationController{

    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }
    }

    public function MakeReservation($guardian_id){
        $reservation_DAO = new ReservationDAO();
        $guardian_DAO = new GuardianDAO();
        $owner_DAO = new OwnerDAO();
        $pet_DAO = new PetDAO;

        $user_guardian = $guardian_DAO->GetById($guardian_id);
        $petList = $pet_DAO->GetPetsByOwner($_SESSION["id"]);

        //var_dump($petList);

        $user_owner = $owner_DAO->GetById($_SESSION["id"]);
        
        /*$reservation->setGuardian_id($guardian_id);
        $reservation->setPrice(500);*/

        require_once VIEWS_PATH . "make_reservation.php";
    }

}
?>