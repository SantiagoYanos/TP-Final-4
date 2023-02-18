<?php

namespace Controllers;

//use DAO\GuardianDAO as GuardianDAO;
//use DAO\OwnerDAO as OwnerDAO;

use SQLDAO\ReviewDAO as ReviewDAO;
use SQLDAO\GuardianDAO as GuardianDAO;
use SQLDAO\OwnerDAO as OwnerDAO;
use SQLDAO\ReservationDAO;
use Models\User as User;
use Models\Guardian as Guardian;

use GuardianNotFoundException;
use OwnerNotFoundException;

use \Exception as Exception;

class GuardianController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
        require_once(ROOT . "/Utils/encrypt.php");
        require_once(ROOT . "/Exceptions/GuardianNotFoundException.php");
        require_once(ROOT . "/Exceptions/OwnerNotFoundException.php");

        if ($_SESSION["type"] == "owner") {
            header("location: " . FRONT_ROOT . "Owner/HomeOwner");
        }
    }

    public function HomeGuardian($alert = null, $id = null)
    {
        try {
            //var_dump($_SESSION);

            $user = new GuardianDAO();
            $reviewDAO = new ReviewDAO();

            $user = $user->GetByid($_SESSION["id"]);

            $ratingPercent = (($user->getType_Data()->getReputation() * 100) / 5);

            $reviewsAmount = $reviewDAO->calculateRating($_SESSION["id"])["quantity"];

            //Guardar la cantidad de reviews para poder mostrarla.

            require_once VIEWS_PATH . "home_guardian.php";
        } catch (GuardianNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            //header("location: " . FRONT_ROOT . "Auth/ShowLogin");
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    /*public function updateAvDates($monday = null, $tuesday = null, $wednesday = null, $thursday = null, $friday = null, $saturday = null, $sunday = null)
    {
        $guardian_DAO = new GuardianDAO();

        $guardian_DAO->UpdateAvailableDates($_SESSION["email"], $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
        header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
    }*/

    public function updateAvDates($stringDates)
    {
        try {
            $guardian_DAO = new GuardianDAO();

            if ($stringDates != "") {
                $arrayDates = explode(",", $stringDates);
                $guardian_DAO->AddAvailableDates($_SESSION["id"], $arrayDates);
            } else {
                $guardian_DAO->AddAvailableDates($_SESSION["id"], []);
            }

            header("location: " . FRONT_ROOT . 'Guardian/HomeGuardian?alert=' . "Available dates updated succesfully!");
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function ShowEdit($alert = null)
    {
        try {
            $user = new GuardianDAO();

            $user = $user->GetByid($_SESSION["id"]);

            require_once VIEWS_PATH . "edit_guardian.php";
        } catch (GuardianNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function Edit($preferred_size, $preferred_size_cat, $price = null, $birth_date = null, $cuil = null,  $name = null, $last_name = null, $adress = null, $phone = null)
    {
        try {
            $guardianDAO = new GuardianDAO();

            //Chequear si ya existe un usuario con ese CUIL.
            $userFound = $guardianDAO->CUILExists($cuil);

            if ($userFound && $userFound != $_SESSION["id"]) {
                return header("location: " . FRONT_ROOT . "Guardian/ShowEdit?alert=" . "CUIL is already in use");
            }

            // Chequear si la fecha de nacimiento es del futúro 
            if ($birth_date > date("Y-m-d", time())) {
                return header("location: " . FRONT_ROOT . "Guardian/ShowEdit?alert=" . "Can't set a future date as birth date");
            }

            //Si los valores preferidos son los permitidos
            if (!is_numeric($preferred_size) || !is_numeric($preferred_size_cat) || ($preferred_size > 3 || $preferred_size_cat > 3) || ($preferred_size_cat < 1 || $preferred_size < 1)) {
                return header("location: " . FRONT_ROOT . "Guardian/ShowEdit?alert=" . "Invalid preferred size selected");
            }

            //Chequear si el precio es positivo
            if (!is_numeric($price) || $price < 0) {
                return header("location: " . FRONT_ROOT . "Guardian/ShowEdit?alert=" . "Can't set a negative price");
            }

            $user = new User();

            $user->setId($_SESSION["id"]);

            $user->setName($name);

            $user->setLast_name($last_name);

            $user->setAdress($adress);

            $user->setPhone($phone);

            $user->setBirth_date($birth_date);


            $guardian = new Guardian();

            $guardian->setPreferred_size($preferred_size);

            $guardian->setPreferred_size_cat($preferred_size_cat);

            $guardian->setCuil($cuil);

            $guardian->setPrice($price);

            $guardianDAO->Edit($user, $guardian);

            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian?alert=Profile edited succesfully");
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function ViewReservations($state = null, $rejected = false, $canceled = false, $alert = null)
    {

        try {

            $reservationDAO = new ReservationDAO();

            $state = $state && $state == "*" ? null : $state;

            $reservations = $reservationDAO->GetByGuardianOrOwner($_SESSION["id"], "guardian", $state, $rejected, $canceled);

            $rejectedCheck = $rejected ? "checked" : "";

            $canceledCheck = $canceled ? "checked" : "";

            require_once VIEWS_PATH . "guardian_reservationsList.php";
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    function ViewOwnerProfile($id, $back = null) //Encripted
    {
        try {

            $ownerDAO = new OwnerDAO();

            $id = decrypt($id);

            $id ? null : throw new OwnerNotFoundException();

            $owner = $ownerDAO->GetById($id);

            if ($owner) {
                require_once VIEWS_PATH . "guardian_OwnerProfile.php";
            } else {
                header("location: " . FRONT_ROOT . "Guardian/ViewReservations");
            }
        } catch (OwnerNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }
}
