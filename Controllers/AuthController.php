<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;

class AuthController
{

    public function Register()
    {
    }

    public function Login($email, $password)
    {
        $guardian_DAO = new GuardianDAO();
        $owner_DAO = new OwnerDAO();

        $user = $guardian_DAO->GetByEmail($email);

        if ($user) {
            if ($user->getPassword() == $password) {

                //Crear sesión
                session_start();

                $_SESSION["email"] = $user->getEmail();

                $_SESSION["type"] = "guardian";

                //Redirigir a perfil Guardian (return)
                return require_once("VIEWS_PATH" . "home_guardian.php");
            }
        }

        $user = $owner_DAO->getByEmail($email);

        if ($user) {
            if ($user->getPassword() == $password) {

                //Crear sesión
                session_start();

                $_SESSION["email"] = $user->getEmail();

                $_SESSION["type"] = "owner";

                //Redirigir a perfil Owner (return)
                return require_once("VIEWS_PATH" . "home_owner.php");
            }
        }

        //Redirigir a Login otra vez (return)
        return require_once("VIEWS_PATH" . "login.php");
    }
}
