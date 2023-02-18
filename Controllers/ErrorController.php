<?php

namespace Controllers;

class ErrorController
{

    function __construct()
    {
        session_start();
    }

    function ShowError($error)
    {
        return require_once(VIEWS_PATH . "/error.php");
    }
}
