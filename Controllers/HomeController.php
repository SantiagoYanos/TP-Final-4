<?php

namespace Controllers;

class HomeController
{
    public function Index($message = "")
    {
        header("location: " . FRONT_ROOT . "Auth/ShowLogin");
    }
}
