<?php

namespace Controllers;

use SQLDAO\MessageDAO as MessageDAO;
use SQLDAO\UserDAO as UserDAO;
use Models\User as User;
use \Exception as Exception;
use Models\Message as Message;

class ChatController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
        require_once(ROOT . "/Utils/encrypt.php");

        /*if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }*/
    }

    public function ShowChat($idReceiver) //Encripted
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
                //$backLink = FRONT_ROOT . "Guardian/HomeGuardian";
                $receiverLink = FRONT_ROOT . "Guardian/ViewOwnerProfile";
                $reservationsLink = FRONT_ROOT . "Guardian/ViewReservations";
            } else {
                //$backLink = FRONT_ROOT . "Owner/HomeOwner";
                $receiverLink = FRONT_ROOT . "Owner/ViewGuardianProfile";
                $reservationsLink = FRONT_ROOT . "Owner/ViewReservationsOwner";
            }

            // $sended=$messageDAO->GetByIds($_SESSION["id"],$idReceiver);
            // $received=$messageDAO->GetByIds($idReceiver,$_SESSION["id"]);

            // $total = array_merge($sended, $received);

            // usort($total, function($a, $b) {

            //     if ($a->getDate() == $b->getDate())
            //     {
            //         return 0;
            //     }
            //     return $a->getDate() < $b->getDate() ? -1 : 1;
            // });

            //return require_once(VIEWS_PATH . "PrettyChat.php");

            return require_once(VIEWS_PATH . "chatV2.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function sendMessage($description, $userId) //Encripted
    {
        $messageDAO = new MessageDAO;

        $message = new Message;

        try {

            $decryptedUserId = decrypt($userId);

            $decryptedUserId ? null : throw new Exception("User not found");

            $message->setDescription($description);
            $message->setReceiver($decryptedUserId);
            $message->setSender($_SESSION["id"]);
            //$message->setDate(date("Y-m-d-H-i-s") );

            $messageDAO->Add($message);

            header("location: " . FRONT_ROOT . "Chat/ShowChat" . "?id=" . $userId);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
