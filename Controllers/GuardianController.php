<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;

class GuardianController
{
    public function HomeGuardian($email)
    {
        require_once VIEWS_PATH . "home_guardian.php";
    }
}
