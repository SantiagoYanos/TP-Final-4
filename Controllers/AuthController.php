<?php

namespace Controllers;

use SQLDAO\GuardianDAO as GuardianDAO;
use SQLDAO\OwnerDAO as OwnerDAO;
use Models\Guardian as Guardian;
use Models\Owner as Owner;

use SQLDAO\UserDAO as UserDAO;

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

    public function RegisterOwner($name, $last_name, $adress, $phone, $email, $password, $birth_date, $dni)
    {
        $ownerDAO = new OwnerDAO();

        $userDAO = new UserDAO();

        $userArray = [];
        $userArray["user_id"]=0;
        $userArray["name"] = $name;
        $userArray["last_name"] = $last_name;
        $userArray["adress"] = $adress;
        $userArray["phone"] = $phone;
        $userArray["email"] = $email;
        $userArray["password"] = $password;
        $userArray["birth_date"] = $birth_date;

        $newUser = $userDAO->LoadData($userArray);

        //Continuar
    }

    public function RegisterGuardian($name, $last_name, $adress, $phone, $email, $password, $birth_date, $cuil, $preferred_size, $preferred_size_cat)
    {
        $userDAO = new UserDAO();

        $userArray = array();
        $userArray["user_id"]=0;
        $userArray["name"] = $name;
        $userArray["last_name"] = $last_name;
        $userArray["adress"] = $adress;
        $userArray["phone"] = $phone;
        $userArray["email"] = $email;
        $userArray["password"] = $password;
        $userArray["birth_date"] = $birth_date;

        $newUser = $userDAO->LoadData($userArray);

        $guardianDAO = new GuardianDAO();

        $guardianArray = array();

        $guardianArray["cuil"] = $cuil;
        $guardianArray["preferred_size_dog"] = $preferred_size;
        $guardianArray["preferred_size_cat"] = $preferred_size_cat;
        $guardianArray["reputation"] = 0;
        $guardianArray["available_date"] = null;
        $guardianArray["price"] = 500;

        $newGuardian = $guardianDAO->LoadData($guardianArray);

        $guardianDAO->Add($newUser, $newGuardian);

        return require_once(VIEWS_PATH . "login.php");
    }



    // public function RegisterOwner($name, $last_name, $adress, $dni, $phone, $email, $password, $birth_date)
    // {
    //     $ownerDAO = new OwnerDAO;
    //     $guardianDAO = new GuardianDAO;

    //     if ($ownerDAO->GetByEmail($email) || $guardianDAO->GetByEmail($email) || $ownerDAO->GetByDNI($dni)) {
    //         ///redirigir al index;
    //         ///existe el owner o guardian con el email ingresado;
    //         return require_once(VIEWS_PATH . "register_owner.php");
    //     } else {
    //         $owner = new Owner();

    //         $owner->setName($name);
    //         $owner->setLast_name($last_name);
    //         $owner->setAdress($adress);
    //         $owner->setBirth_date($birth_date);
    //         $owner->setDni($dni);
    //         $owner->setPhone($phone);
    //         $owner->setPets(array());
    //         $owner->setEmail($email);
    //         $owner->setPassword($password);
    //         $ownerDAO->add($owner);

    //         ///creamos la cuenta de owner.

    //         return require_once(VIEWS_PATH . "login.php");
    //     }
    // }

    // ----------------------------------------------------------------------------

    // public function RegisterGuardian($cuil, $name, $last_name, $adress, $phone, $preferred_size, $preferred_size_cat, $email, $password, $birth_date)
    // {
    //     $ownerDAO = new OwnerDAO;
    //     $guardianDAO = new GuardianDAO;

    //     if ($ownerDAO->GetByEmail($email) || $guardianDAO->GetByEmail($email) || $guardianDAO->GetByCuil($cuil)) {
    //         ///redirigir al index;
    //         ///existe el owner o guardian con el email ingresado;
    //         return require_once(VIEWS_PATH . "register_guardian.php");
    //     } else {
    //         $guardian = new Guardian();

    //         $guardian->setCuil($cuil);
    //         $guardian->setName($name);
    //         $guardian->setLast_name($last_name);
    //         $guardian->setAdress($adress);
    //         $guardian->setPhone($phone);
    //         $guardian->setPreferred_size($preferred_size);
    //         $guardian->setPreferred_size_cat($preferred_size_cat);
    //         $guardian->setReputation("3");
    //         $guardian->setPrice(null);
    //         $guardian->setEmail($email);
    //         $guardian->setPassword($password);


    //         $guardian->setAvailable_date(array());

    //         $guardian->setBirth_date($birth_date);

    //         $guardianDAO->Add($guardian);

    //         ///creamos la cuenta de guardian.



    //         return require_once(VIEWS_PATH . "login.php");
    //     }
    // }

    // public function Login($email, $password)
    // {
    //     $guardian_DAO = new GuardianDAO();
    //     $owner_DAO = new OwnerDAO();

    //     $user = $guardian_DAO->GetByEmail($email);

    //     // echo "<script>console.log('Debug Objects: " . $user . "' );</script>";

    //     if ($user != null) {
    //         if ($user->getPassword() == $password) {

    //             //Crear sesión
    //             session_start();

    //             $_SESSION["email"] = $user->getEmail();

    //             $_SESSION["type"] = "guardian";

    //             echo "<script>console.log('Debug Objects: " . var_dump(session_id()) . "' );</script>";

    //             //Redirigir a perfil Guardian (return)
    //             return header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
    //         }
    //     }

    //     $user = $owner_DAO->getByEmail($email);

    //     if ($user != null) {
    //         if ($user->getPassword() == $password) {

    //             //Crear sesión
    //             session_start();

    //             $_SESSION["email"] = $user->getEmail();

    //             $_SESSION["type"] = "owner";

    //             //Redirigir a perfil Owner (return)
    //             return header("location: " . FRONT_ROOT . "Owner/HomeOwner");
    //         }
    //     }

    //     //Redirigir a Login otra vez (return)
    //     return require_once(VIEWS_PATH . "login.php");
    // }

    //----------------------------------------------------------------------------------

    public function Login($email, $password)
    {
        $userDAO = new UserDAO();

        $detectedUser = $userDAO->GetByEmail($email);

        if (!$detectedUser) {
            return header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }

        if ($detectedUser->getPassword()== $password) {
            /*¿Cómo podemos diferenciar los usuarios? 
        
            1. Hacer una llamada a cada tabla
        
            2. Hacer un SELECT al users y con los joins diferenciar los tipos (una query con dos subquerys adentro seguramente)*/


            $typeDetected=$userDAO->getTypeById($detectedUser->getId());

               //Crear sesión
               session_start();

               $_SESSION["email"] = $detectedUser->getEmail();
               $_SESSION["id"] = $detectedUser->getId();

               

            var_dump($typeDetected);

            if ($typeDetected["type"] == "owner") {
                $_SESSION["type"] = "owner";
                return header("location: " . FRONT_ROOT . "Owner/HomeOwner");
            } else {
                $_SESSION["type"] = "guardian";
                return header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
            }


        }

        return header("location: " . FRONT_ROOT . "Auth/ShowLogin");
    }

    public function logOut()
    {
        session_start();
        if ($_SESSION["email"]) {
            session_destroy();
            return header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    //-----------------------------------------------------------------------------------
}
