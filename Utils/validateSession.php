<?php
if (!isset($_SESSION["email"])) {
    header("location: " . FRONT_ROOT . "Auth/ShowLogin");
}
