<?php

namespace Controllers;

use Models\Payment;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\PaymentDAO as PaymentDAO;
use Exception as Exception;

class PaymentController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
    }

    public function ShowPayment($reservation_id)
    {
        try {


            $payment = new PaymentDAO();

            $arrayPayment = array();
            $arrayPayment = $payment->GetByReservationId($reservation_id);

            return require_once(VIEWS_PATH . "show_payment.php");
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function ShowMakePayment($reservation_id)
    {

        try {
            $reservationDAO = new ReservationDAO;
            $reservation = $reservationDAO->getById($reservation_id);

            if ($reservation->getOwner_id() != $_SESSION["id"]) {
                header("location: " . FRONT_ROOT . "/Owner/ViewReservationsOwner");
            }

            $encryptedPrice = openssl_encrypt($reservation->getPrice() / 2, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
            $encryptedReservation_id = openssl_encrypt($reservation->getId(), "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
            $encryptedOwner_id = openssl_encrypt($reservation->getOwner_id(), "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
            $encryptedGuardian_id = openssl_encrypt($reservation->getGuardian_id(), "aes-128-cbc", SECRET, 0, $_SESSION["token"]);

            return require_once(VIEWS_PATH . "ShowMakePayment.php");
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }

    public function MakePayment($price, $reservation_id, $owner_id, $guardian_id)
    {
        try {

            $paymentDAO = new PaymentDAO();

            //Crear el pago (agregarlo)

            $decryptedPrice = openssl_decrypt($price, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
            $decryptedReservation_id = openssl_decrypt($reservation_id, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
            $decryptedOwner_id = openssl_decrypt($owner_id, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
            $decryptedGuardian_id = openssl_decrypt($guardian_id, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);

            $paymentExist = $paymentDAO->GetByReservationId($decryptedReservation_id);

            if ($paymentExist) {
                header("location: " . FRONT_ROOT . 'Owner/ViewReservationsOwner?state=&alert="This reservation has been already paid"');
            }

            $paymentDAO = new PaymentDAO;
            $payment = new Payment;
            $payment->setAmount($decryptedPrice);
            $payment->setReservation_id($decryptedReservation_id);
            $payment->setOwner_id($decryptedOwner_id);
            $payment->setGuardian_id($decryptedGuardian_id);
            $payment->setPayment_number(random_int(0, 999999999));

            $paymentDAO->Add($payment);

            $reservationDAO = new ReservationDAO;

            $reservationDAO->updateState($decryptedReservation_id, "Paid");

            header("location: " . FRONT_ROOT . "Payment/ShowPayment?reservation_id= $decryptedReservation_id");
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }
}
