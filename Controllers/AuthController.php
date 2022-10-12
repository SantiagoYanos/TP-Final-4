<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;
use Models\Guardian as Guardian;
use Models\Owner as Owner;

class AuthController
{

    public function ShowChooseSide()
    {
        require_once(VIEWS_PATH . "ChooseSide.php");
    }

    public function ShowRegisterOwner()
    {
        return require_once(VIEWS_PATH . "register_owner.php");
    }

    public function ShowRegisterGuardian()
    {
        return require_once(VIEWS_PATH . "register_guardian.php");
    }

    public function ShowLogin()
    {
        return require_once(VIEWS_PATH . "login.php");
    }



    public function RegisterOwner($name, $last_name, $adress, $dni, $phone, $email, $password, $birth_date)
    {
        $ownerDAO = new OwnerDAO;
        $guardianDAO = new GuardianDAO;

        if ($ownerDAO->getByEmail($email) || $guardianDAO->getByEmail($email)) {
            ///redirigir al index;
            ///existe el owner o guardian con el email ingresado;
            return require_once(VIEWS_PATH . "register_owner.php");
        } else {
            $owner = new Owner();

            $owner->setName($name);
            $owner->setLast_name($last_name);
            $owner->setAdress($adress);
            $owner->setBirth_date($birth_date);
            $owner->setDni($dni);
            $owner->setPhone($phone);
            $owner->setPets(array());
            $owner->setEmail($email);
            $owner->setPassword($password);
            $ownerDAO->add($owner);

            ///creamos la cuenta de owner.

            return require_once(VIEWS_PATH . "login.php");
        }
    }

    public function RegisterGuardian($cuil, $name, $last_name, $adress, $phone, $prefered_size, $email, $password, $birth_date)
    {
        $ownerDAO = new OwnerDAO;
        $guardianDAO = new GuardianDAO;

        if ($ownerDAO->getByEmail($email) || $guardianDAO->getByEmail($email)) {
            ///redirigir al index;
            ///existe el owner o guardian con el email ingresado;
            return require_once(VIEWS_PATH . "register_guardian.php");
        } else {
            $guardian = new Guardian();

            $guardian->setCuil($cuil);
            $guardian->setName($name);
            $guardian->setLast_name($last_name);
            $guardian->setAdress($adress);
            $guardian->setPhone($phone);
            $guardian->setPrefered_size($prefered_size);
            $guardian->setReputation("3");
            $guardian->setPrice(null);
            $guardian->setEmail($email);
            $guardian->setPassword($password);
            
            $valuesArray = array();
            $valuesArray["monday"] = null;
            $valuesArray["tuesday"] = null;
            $valuesArray["wednesday"] =null;
            $valuesArray["thursday"] = null;
            $valuesArray["friday"] = null;
            $valuesArray["saturday"] = null;
            $valuesArray["sunday"] = null;
            $guardian->setAvailable_date($valuesArray);
            
            $guardian->setBirth_date($birth_date);

            $guardianDAO->Add($guardian);

            ///creamos la cuenta de guardian.



            return require_once(VIEWS_PATH . "login.php");
        }
    }

    public function Login($email, $password)
    {
        $guardian_DAO = new GuardianDAO();
        $owner_DAO = new OwnerDAO();

        $user = $guardian_DAO->GetByEmail($email);

        if ($user != null) {
            if ($user->getPassword() == $password) {

                //Crear sesión
                session_start();

                $_SESSION["email"] = $user->getEmail();

                $_SESSION["type"] = "guardian";

                echo "<script>console.log('Debug Objects: " . var_dump(session_id()) . "' );</script>";

                //Redirigir a perfil Guardian (return)
                return header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
            }
        }

        $user = $owner_DAO->getByEmail($email);


        if ($user != null) {
            if ($user->getPassword() == $password) {

                //Crear sesión
                session_start();

                $_SESSION["email"] = $user->getEmail();

                $_SESSION["type"] = "owner";

                //Redirigir a perfil Owner (return)
                return header("location: " . FRONT_ROOT . "Owner/HomeOwner");
            }
        }

        //Redirigir a Login otra vez (return)
        return require_once(VIEWS_PATH . "login.php");
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
