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

    public function Login($email, $password)
    {
    }
}
