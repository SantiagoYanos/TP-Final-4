<?php

namespace Controllers;

use SQLDAO\MessageDAO as MessageDAO;
use SQLDAO\UserDAO as UserDAO;
use Models\User as User;
use \Exception as Exception;
use Models\Message as Message;
use UserNotFoundException;

class ChatController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
        require_once(ROOT . "/Utils/encrypt.php");
        require_once(ROOT . "/Exceptions/UserNotFoundException.php");
    }

    public function ShowChat($idReceiver)
    {
        $messageDAO = new MessageDAO;
        $userDAO = new UserDAO;

        try {

            $idReceiver = decrypt($idReceiver);

            $idReceiver ? null : throw new Exception("Chat not found");

            $sended = array();
            $received = array();
            $total = array();

            $me = $userDAO->GetById($_SESSION["id"]);

            $you = $userDAO->GetById($idReceiver);

            $meName = $me->getName() . " " . $me->getLast_name();

            $youName = $you->getName() . " " . $you->getLast_name();

            $total = $messageDAO->GetByIdsV2($_SESSION["id"], $idReceiver);

            $encryptedId = encrypt($idReceiver);

            if ($_SESSION["type"] == "guardian") {

                $receiverLink = FRONT_ROOT . "Guardian/ViewOwnerProfile";
                $reservationsLink = FRONT_ROOT . "Guardian/ViewReservations";
            } else {

                $receiverLink = FRONT_ROOT . "Owner/ViewGuardianProfile";
                $reservationsLink = FRONT_ROOT . "Owner/ViewReservationsOwner";
            }

            return require_once(VIEWS_PATH . "chatV2.php");
        } catch (UserNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }

    public function sendMessage($description, $userId)
    {
        $messageDAO = new MessageDAO;

        $message = new Message;

        try {

            $decryptedUserId = decrypt($userId);

            $decryptedUserId ? null : throw new UserNotFoundException();

            $message->setDescription($description);
            $message->setReceiver($decryptedUserId);
            $message->setSender($_SESSION["id"]);

            $messageDAO->Add($message);

            header("location: " . FRONT_ROOT . "Chat/ShowChat" . '?idReceiver=' . $userId); //

            //header("location: " . FRONT_ROOT . "Chat/ShowChat" . '?idReceiver=' . $userId);
        } catch (UserNotFoundException $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        } catch (Exception $e) {
            return header("location: " . FRONT_ROOT . "Error/ShowError?error=" . $e->getMessage());
        }
    }
}
