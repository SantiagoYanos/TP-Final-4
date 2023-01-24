<?php

namespace Controllers;

use SQLDAO\GuardianDAO;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\PaymentDAO as PaymentDAO;
use SQLDAO\OwnerDAO as OwnerDAO;

use Models\Payment;
//use Exception as Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class PaymentController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
    }

    public function SendEmailPayment($email)
    {
        /*require ROOT . "PHPMailer\Exception.php";
        require ROOT . "PHPMailer\PHPMailer.php";
        require ROOT . "PHPMailer\SMTP.php";

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        //$email->isSMTP();
        $email->Host="smtp.gmail.com";
        $email->Port=587;
        $email->SMTPSecure="tls";
        $email->Usermail="pethero30000@gmail.com";
        $email->Password="Pethero30000!";
        $mail->setFrom("pethero30000@gmail.com", "asdasd");
        $email->addAddress($email);
        $email->Subject="Pagaste !";
        $email->msgHTML("Gracias por pagar!");

        if($email->send()){
            echo "<script type='text/javascript'>alert('Receipt sent!');</script>";
            return require_once(VIEWS_PATH . "show_payment.php");
        }*/

        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'pethero30000@gmail.com';                     //SMTP username
            $mail->Password   = 'uybgwehmdppanzkv';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('pethero30000@gmail.com', "Pet Hero Support");
            $mail->addAddress($email, "Dear Customer");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Payment Receipt';
            $mail->Body    = 'Thank you for using Pet Hero! Here is your receipt. :-)';
            $mail->AddAttachment(ROOT . 'PHPMailer/PHPMailer/recibo.png');

            $mail->send();

            return header("location: " . FRONT_ROOT . "/Owner/ViewReservationsOwner");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
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

            header("location: " . FRONT_ROOT . "Payment/ShowPayment?reservation_id=$decryptedReservation_id");
        } catch (Exception $e) {
            header("location: " . FRONT_ROOT . "Auth/ShowLogin");
        }
    }


    public function ShowPaymentCupon($reservation_id)
    {

        $reservationDAO = new ReservationDAO;
        $guardianDAO = new GuardianDAO;
        $ownerDAO = new OwnerDAO;

        $reservation = $reservationDAO->getById($reservation_id);

        $guardian = $guardianDAO->getById($reservation->getGuardian_id());

        $owner = $ownerDAO->getById($reservation->getOwner_id());

        $coupon["guardianName"] = $guardian->getName() . " " . $guardian->getLast_name();
        $coupon["ownerName"] = $owner->getName() . " " . $owner->getLast_name();
        $coupon["guardianCUIL"] = $guardian->getType_data()->getCuil();
        $coupon["ownerDNI"] = $owner->getType_data()->getDni();
        $coupon["import"] = $reservation->getPrice() / 2;
        $coupon["daysAmount"] = count($reservation->getDates());
        $coupon["petsAmount"] = count($reservation->getPets());


        //"Pet-sitting reservation | " . count($reservation->getDates()) . " days | " . count($reservation->getPets()) . " pets";


        return require_once(VIEWS_PATH . "paymentcupon.php");
    }
}
