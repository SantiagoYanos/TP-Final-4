<?php

function crearDatepicker($id, $dates)
{

    $calendario = "<script type='text/javascript'> 
    
    $(function() {

    $('#" . $id . "').datepicker({ multidate: true, format: 'yyyy-mm-dd' })";

    if ($dates) {
        $calendario = $calendario . "$('#" . $id . "').datepicker('setDates',['" . join("','", $dates) . "'])";
    }

    $calendario = $calendario . "
        });
    </script>";

    echo $calendario;
}
