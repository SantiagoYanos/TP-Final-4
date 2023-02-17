<?php

namespace Controllers;

class ErrorController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
    }

    function ShowError($error)
    {
        return require_once(VIEWS_PATH . "/error.php");
    }
}
