<?php

namespace Controllers;

use SQLDAO\ReservationDAO as ReservationDAO;

class PaymentController
{
    public function ShowPayment()
    {
        //Ver un pago ya hecho desde el guardian o el owner
        echo "algo1";
    }

    public function ShowMakePayment($reservationId)
    {
        //Mostrar página para realizar un pago
        echo "algo";
    }

    public function MakePayment()
    {
        echo "algo2";
        //Crear el pago (agregarlo)
    }
}
