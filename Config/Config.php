<?php

namespace Config;

//str_replace("\ ." , ". / .", dirname(__DIR__));

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define("FRONT_ROOT", "/TP4/TP-Final-4/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT . VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT . VIEWS_PATH . "js/");
define("IMG_PATH", VIEWS_PATH . "images/pets/");

//Datos, FALTAN CAMBIARLOS
define("DB_HOST", "localhost");
define("DB_NAME", "pet_hero");
define("DB_USER", "root");
define("DB_PASS", "");
