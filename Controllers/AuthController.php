<?php

namespace Controllers;

//use DAO\GuardianDAO as GuardianDAO;
//use DAO\OwnerDAO as OwnerDAO;
//use DAO\UserDAO as UserDAO;

use \Exception as Exception;
use SQLDAO\GuardianDAO as GuardianDAO;
use SQLDAO\OwnerDAO as OwnerDAO;
use SQLDAO\UserDAO as UserDAO;
use Models\Guardian as Guardian;
use Models\Owner as Owner;


class AuthController
{

    function __construct()
    {
        session_start();

        if (isset($_SESSION["email"])) {
            if ($_SESSION["type"] == "owner") {
                return header("location: " . FRONT_ROOT . "Owner/HomeOwner");
            } else {
                return header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
            }
        }
    }

    public function ShowChooseSide()
    {
        require_once(VIEWS_PATH . "ChooseSide.php");
    }

    public function ShowRegisterOwner($alert = null)
    {
        return require_once(VIEWS_PATH . "register_owner.php");
    }

    public function ShowRegisterGuardian($alert = null)
    {
        return require_once(VIEWS_PATH . "register_guardian.php");
    }

    public function ShowLogin($alert = null)
    {
        return require_once(VIEWS_PATH . "login.php");
    }

    public function Index()
    {
        header("location: " . FRONT_ROOT . "Auth/ShowLogin");
    }

    public function RegisterOwner($name, $last_name, $adress, $phone, $email, $password, $birth_date, $dni)
    {
        try {

            // Creación del User
            $userDAO = new UserDAO();
            $ownerDAO = new OwnerDAO();

            //Chequear si ya existe un usuario con ese email.
            $userFound = $userDAO->GetByEmail($email);

            if ($userFound) {
                return header("location: " . FRONT_ROOT . "Auth/ShowRegisterOwner?alert=" . "Email is already in use");
            }

            //Chequear si ya existe un usuario con ese dni.
            $userFound = $ownerDAO->DNIExists($dni);

            if ($userFound) {
                return header("location: " . FRONT_ROOT . "Auth/ShowRegisterOwner?alert=" . "DNI is already in use");
            }

            // Chequear si la fecha de nacimiento es del futúro 
            if ($birth_date > date("Y-m-d", time())) {
                return header("location: " . FRONT_ROOT . "Auth/ShowRegisterOwner?alert=" . "Can't set a future date as birth date");
            }

            $userArray = array();
            $userArray["user_id"] = 0;
            $userArray["name"] = $name;
            $userArray["last_name"] = $last_name;
            $userArray["adress"] = $adress;
            $userArray["phone"] = $phone;
            $userArray["email"] = $email;
            $userArray["password"] = $password;
            $userArray["birth_date"] = $birth_date;

            $newUser = $userDAO->LoadData($userArray);

            // Creación del Owner
            $ownerDAO = new OwnerDAO();

            $ownerArray = array();

            $ownerArray["dni"] = $dni;

            $newOwner = $ownerDAO->LoadData($ownerArray);

            $ownerDAO->Add($newUser, $newOwner);

            return header("location: " . FRONT_ROOT . "Auth/ShowLogin?alert=Success! Your account has been created.");
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function RegisterGuardian($name, $last_name, $adress, $phone, $email, $password, $birth_date, $cuil, $preferred_size, $preferred_size_cat)
    {

        try {

            $userDAO = new UserDAO();

            $guardianDAO = new GuardianDAO();

            //Chequear si ya existe un usuario con ese email.
            $userFound = $userDAO->GetByEmail($email);

            if ($userFound) {
                return header("location: " . FRONT_ROOT . "Auth/ShowRegisterGuardian?alert=" . "Email is already in use");
            }

            //Chequear si ya existe un usuario con ese CUIL.
            $userFound = $guardianDAO->CUILExists($cuil);

            if ($userFound) {
                return header("location: " . FRONT_ROOT . "Auth/ShowRegisterGuardian?alert=" . "CUIL is already in use");
            }

            // Chequear si la fecha de nacimiento es del futúro 
            if ($birth_date > date("Y-m-d", time())) {
                return header("location: " . FRONT_ROOT . "Auth/ShowRegisterGuardian?alert=" . "Can't set a future date as birth date");
            }

            //Si los valores preferidos son los permitidos
            if (!is_numeric($preferred_size) || !is_numeric($preferred_size_cat) || ($preferred_size > 3 || $preferred_size_cat > 3) || ($preferred_size_cat < 1 || $preferred_size < 1)) {
                return header("location: " . FRONT_ROOT . "Auth/ShowRegisterGuardian?alert=" . "Invalid preferred size selected");
            }

            $userArray = array();
            $userArray["user_id"] = 0;
            $userArray["name"] = $name;
            $userArray["last_name"] = $last_name;
            $userArray["adress"] = $adress;
            $userArray["phone"] = $phone;
            $userArray["email"] = $email;
            $userArray["password"] = $password;
            $userArray["birth_date"] = $birth_date;

            $newUser = $userDAO->LoadData($userArray);

            ///////

            $guardianArray = array();

            $guardianArray["cuil"] = $cuil;
            $guardianArray["preferred_size_dog"] = $preferred_size;
            $guardianArray["preferred_size_cat"] = $preferred_size_cat;
            $guardianArray["reputation"] = null;
            $guardianArray["available_date"] = null;
            $guardianArray["price"] = null;

            $newGuardian = $guardianDAO->LoadData($guardianArray, null);

            $guardianDAO->Add($newUser, $newGuardian);

            return header("location: " . FRONT_ROOT . "Auth/ShowLogin?alert=Success! Your account has been created.");
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function Login($email, $password)
    {
        try {
            $userDAO = new UserDAO();

            $detectedUser = $userDAO->GetByEmail($email);

            if ($detectedUser && $detectedUser->getPassword() == $password) {

                $typeDetected = $userDAO->getTypeById($detectedUser->getId());

                //Crear sesión
                session_start();

                $_SESSION["email"] = $detectedUser->getEmail();
                $_SESSION["id"] = $detectedUser->getId();
                $_SESSION["token"] = random_bytes(16);

                if ($typeDetected["type"] == "owner") {
                    $_SESSION["type"] = "owner";
                    return header("location: " . FRONT_ROOT . "Owner/HomeOwner");
                } else {
                    $_SESSION["type"] = "guardian";
                    return header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
                }
            }

            return header("location: " . FRONT_ROOT . 'Auth/ShowLogin?alert=Email or Password incorrect');
        } catch (Exception $ex) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $ex->getMessage());
        }
    }

    public function logOut()
    {
        session_start();
        if ($_SESSION["email"]) {
            session_destroy();
            return header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }
}
