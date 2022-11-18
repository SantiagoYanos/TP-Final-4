<?php

namespace Controllers;

use Models\Payment;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\PaymentDAO as PaymentDAO;
use Exception as Exception;

class PaymentController
{
  



    public function ShowPayment($id_reservation)
    {
        try{

        
        $payment=new PaymentDAO;


        $arrayPayment=$payment->GetByReservationId($id_reservation);
        
        header("location: " . FRONT_ROOT . "Payment/show_payment");
    } catch (Exception $e) {
        header("location: " . FRONT_ROOT . "Auth/ShowLogin");
    }
    }

    public function ShowMakePayment($id_reservation)
    {
        try{
        $reservationDAO=new ReservationDAO;
        $reservation=$reservationDAO->getById($id_reservation);

        return require_once(VIEWS_PATH . "ShowMakePayment.php");
    } catch (Exception $e) {
        header("location: " . FRONT_ROOT . "Auth/ShowLogin");
    }
    }

    public function MakePayment($amount, $reservation_id, $owner_id, $guardian_id)
    {
        try{
        echo "algo2";
        //Crear el pago (agregarlo)

        $paymentDAO=new PaymentDAO;
        $payment=new Payment;
        $payment->setAmount($amount);
        $payment->setReservation_id($reservation_id);
        $payment->setOwner_id($owner_id);
        $payment->setGuardian_id($guardian_id);
        $payment->setPayment_number(random_int(0,999999999));

        $paymentDAO->Add($payment);
        
        $this->ShowPayment($reservation_id);
    } catch (Exception $e) {
        header("location: " . FRONT_ROOT . "Auth/ShowLogin");
    }

    }
}
