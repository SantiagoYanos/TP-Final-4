<?php

namespace Controllers;

use SQLDAO\UserDAO;
use SQLDAO\GuardianDAO;
use SQLDAO\ReservationDAO as ReservationDAO;
use SQLDAO\PaymentDAO as PaymentDAO;
use SQLDAO\OwnerDAO as OwnerDAO;
use Models\User;
use Models\Payment;
use Exception as Exception;
use Models\message;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;
use PHPMailer\PHPMailer\SMTP;
use FPDF as FPDF;
use GuardianNotFoundException;
use Models\Reservation;
use OwnerNotFoundException;
use PaymentNotFoundException;
use ReservationNotFoundException;

class PaymentController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
        require_once(ROOT . "/Utils/encrypt.php");
        require_once(ROOT . "/Utils/fpdf/fpdf.php");
        require_once(ROOT . "/Exceptions/PaymentNotFoundException.php");
        require_once(ROOT . "/Exceptions/ReservationNotFoundException.php");
        require_once(ROOT . "/Exceptions/GuardianNotFoundException.php");
        require_once(ROOT . "/Exceptions/OwnerNotFoundException.php");
    }

    public function ShowPayment($reservation_id) //Encripted
    {
        try {
            $paymentDAO = new PaymentDAO();

            $reservation_id = decrypt($reservation_id);

            $reservation_id ? null : throw new ReservationNotFoundException();

            $payment = $paymentDAO->GetByReservationId($reservation_id);

            return require_once(VIEWS_PATH . "show_payment.php");
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function ShowMakePayment($reservation_id) //Encripted
    {

        try {
            $reservationDAO = new ReservationDAO;

            $reservation_id = decrypt($reservation_id);

            $reservation_id ? null : throw new ReservationNotFoundException();

            $reservation = $reservationDAO->getById($reservation_id);

            if ($reservation->getOwner_id() != $_SESSION["id"]) {
                header("location: " . FRONT_ROOT . "/Owner/ViewReservationsOwner");
            }

            $encryptedPrice = encrypt($reservation->getPrice() / 2);
            $encryptedReservation_id = encrypt($reservation->getId());
            $encryptedOwner_id = encrypt($reservation->getOwner_id());
            $encryptedGuardian_id = encrypt($reservation->getGuardian_id());

            return require_once(VIEWS_PATH . "ShowMakePayment.php");
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function ShowPaymentCupon($reservation_id) //Encripted
    {

        $reservationDAO = new ReservationDAO;
        $guardianDAO = new GuardianDAO;
        $ownerDAO = new OwnerDAO;

        try {

            $reservation_id = decrypt($reservation_id);

            $reservation_id ? null : throw new ReservationNotFoundException();

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

            return require_once(VIEWS_PATH . "paymentcupon.php");
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (OwnerNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (GuardianNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function MakePayment($price, $reservation_id, $owner_id, $guardian_id) //Encripted
    {
        try {

            $paymentDAO = new PaymentDAO();

            //Crear el pago (agregarlo)

            $decryptedPrice = decrypt($price);
            $decryptedReservation_id = decrypt($reservation_id);
            $decryptedOwner_id = decrypt($owner_id);
            $decryptedGuardian_id = decrypt($guardian_id);

            if (!($decryptedPrice && $decryptedReservation_id && $decryptedOwner_id && $decryptedGuardian_id)) {
                throw new Exception("Payment arguments error");
            }

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

            header("location: " . FRONT_ROOT . 'Payment/ShowPayment?reservation_id="' . $reservation_id . '"');
        } catch (PaymentNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function SendEmailPayment($reservationId)
    {
        try {

            $paymentDAO = new PaymentDAO();

            $reservationId = decrypt($reservationId);

            $reservationId ? null : throw new ReservationNotFoundException();

            $payment = $paymentDAO->GetByReservationId($reservationId);

            if (!$payment) {
                throw new PaymentNotFoundException();
            }

            $ownerDAO = new OwnerDAO();

            $userDAO = new UserDAO();
            $user = $userDAO->GetById($_SESSION["id"]);
            $email = $user->getEmail();

            //----------------------------- CREACION MAIL --------------------------

            $mail = new PHPMailer(true);

            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL_USERNAME;                     //SMTP username
            $mail->Password   = EMAIL_PASSWORD;                            //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(EMAIL_USERNAME, "Pet Hero Support");
            $mail->addAddress($email, "Dear Customer");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Payment Receipt';
            $mail->Body    = 'Thank you for using Pet Hero! Here is your receipt. :-)';
            //$mail->AddAttachment(ROOT . 'PHPMailer/PHPMailer/recibo.png');

            //----------------------------------------------------------------------

            // ---------------------------- CREACION PDF ---------------------------

            $pdf = new FPDF();

            $pdf->SetMargins(0, 0, 0);

            $pdf->AddPage();
            $pdf->SetFont('Times', 'B', 16);

            $pdf->Image(ROOT . "/Views/images/pethero.png", $pdf->GetPageWidth() / 2 - 60, null, 120, 70);

            $pdf->Cell(0, 10, "", 0, 1, 'C');

            $pdf->Cell(0, 10, 'Pet Hero - Payment Receipt', 0, 1, 'C');

            $pdf->SetFont('Times', 'B', 12);

            $pdf->Cell(0, 10, 'Payment Number: ' . $payment->getPayment_number(), 0, 1, 'C');
            $pdf->Cell(0, 10, 'Date: ' . $payment->getDate(), 0, 1, 'C');
            $pdf->Cell(0, 10, 'Owner: ' . $payment->getOwner_name(), 0, 1, 'C');
            $pdf->Cell(0, 10, 'Guardian: ' . $payment->getGuardian_name(), 0, 1, 'C');
            $pdf->Cell(0, 10, 'Total Price: $' . $payment->getPrice(), 0, 1, 'C');
            $pdf->Cell(0, 10, 'Amount Payed: $' . $payment->getAmount(), 0, 1, 'C');

            $pdf->Cell(0, 10, "", 0, 1, 'C');

            $pdf->Image(ROOT . "/Views/images/perromasfachero.png", $pdf->GetPageWidth() / 2 - 30, null, 60, 60);

            $pdf->Output("F", ROOT . "/PHPMailer/PHPMailer/paymentReceipt.pdf"); //Guarda el PDF

            // -------------------------------------------------------------------------

            $mail->addAttachment(ROOT . '/PHPMailer/PHPMailer/paymentReceipt.pdf'); //Se agrega el PDF

            $mail->send(); //Se envía el Mail

            return header("location: " . FRONT_ROOT . "/Owner/ViewReservationsOwner");
        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (PaymentNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (OwnerNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }

    public function SendEmailCoupon($email, $reservationId)
    {

        try {

            $reservationDAO = new ReservationDAO();
            $guardianDAO = new GuardianDAO();
            $ownerDAO = new OwnerDAO();

            $reservation = $reservationDAO->GetById($reservationId);

            $guardian = $guardianDAO->getById($reservation->getGuardian_id());

            $owner = $ownerDAO->getById($reservation->getOwner_id());

            $coupon["guardianName"] = $guardian->getName() . " " . $guardian->getLast_name();
            $coupon["ownerName"] = $owner->getName() . " " . $owner->getLast_name();
            $coupon["guardianCUIL"] = $guardian->getType_data()->getCuil();
            $coupon["ownerDNI"] = $owner->getType_data()->getDni();
            $coupon["import"] = $reservation->getPrice() / 2;
            $coupon["daysAmount"] = count($reservation->getDates());
            $coupon["petsAmount"] = count($reservation->getPets());

            $mail = new PHPMailer(true);

            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL_USERNAME;                     //SMTP username
            $mail->Password   = EMAIL_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(EMAIL_USERNAME, "Pet Hero Support");
            $mail->addAddress($email, "Dear Customer");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Payment Coupon';
            $mail->Body    = 'Thank you for using Pet Hero! Your reservation was accepted by the Guardian and here is the coupon for you payment. :-)';
            $mail->AddAttachment(ROOT . 'PHPMailer/PHPMailer/cupon.png');

            // ---------------------------- CREACION PDF ---------------------------

            $pdf = new FPDF();

            $pdf->SetMargins(0, 0, 0);

            $pdf->AddPage();
            $pdf->SetFont('Times', 'B', 16);

            $pdf->Image(ROOT . "/Views/images/pethero.png", $pdf->GetPageWidth() / 2 - 60, null, 120, 70);

            $pdf->Cell(0, 10, "", 0, 1, 'C');

            $pdf->Cell(0, 10, 'Pet Hero - Payment Coupon', 0, 1, 'C');

            $pdf->SetFont('Times', 'B', 12);

            $pdf->Cell(0, 10, 'Guardian: ' . $coupon["guardianName"], 0, 1, 'C');
            $pdf->Cell(0, 10, 'Guardian Cuil: ' . $coupon["guardianCUIL"], 0, 1, 'C');
            $pdf->Cell(0, 10, 'Owner: ' . $coupon["ownerName"], 0, 1, 'C');
            $pdf->Cell(0, 10, 'Owner DNI: ' . $coupon["ownerDNI"], 0, 1, 'C');
            $pdf->Cell(0, 10, 'Amount: $' . $coupon["import"] . ' (1/2)', 0, 1, 'C');
            $pdf->Cell(0, 10, 'Description: ' . $coupon["daysAmount"] .  ' days ' .  $coupon["petsAmount"] . ' pet/s', 0, 1, 'C');

            $pdf->Cell(0, 10, "", 0, 1, 'C');

            $pdf->Image(ROOT . "/Views/images/couponDog.png", $pdf->GetPageWidth() / 2 - 30, null, 60, 60);

            $pdf->Output("F", ROOT . "/PHPMailer/PHPMailer/paymentCoupon.pdf"); //Guarda el PDF

            // -------------------------------------------------------------------------

            $mail->addAttachment(ROOT . '/PHPMailer/PHPMailer/paymentCoupon.pdf'); //Se agrega el PDF

            //$mail->send(); //Se envía el Mail

        } catch (ReservationNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (GuardianNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (OwnerNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
