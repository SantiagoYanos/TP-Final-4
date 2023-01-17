<?php

$petSizesEnum = array(
    "*" => "*",
    "small" => 3,
    "medium" => 2,
    "big" => 1
);

function createOptions($selectedSize, $petSizesEnum)
{

    //Crea las opciones recibiendo los sizes en valor *,small,medium,big

    if (!$selectedSize) {
        $selectedSize = "*";
    }

    foreach ($petSizesEnum as $key => $size) {

        $option = "<option";

        if ($selectedSize == $key) {
            $option = $option . " selected='selected'";
        }

        $option = $option . " value=" . $size . ">" . ucfirst($key) . "</option>";

        echo $option;
    }
}

function createOptionsByIndex($selectedSize, $petSizesEnum)
{

    //Crea las opciones recibiendo los sizes en número *,1,2,3

    if (!$selectedSize) {
        $selectedSize = "*";
    }

    foreach ($petSizesEnum as $key => $size) {

        $option = "<option";

        if ($selectedSize == $size) {
            $option = $option . " selected='selected'";
        }

        $option = $option . " value=" . $size . ">" . ucfirst($key) . "</option>";

        echo $option;
    }
}

function ShowValuePetSize($petSize)
{
    switch ($petSize) {
        case 1:
            echo "Big";
            break;
        case 2:
            echo "Medium";
            break;
        case 3:
            echo "Small";
            break;
        default:
            echo "Undefined";
            break;
    }
}
