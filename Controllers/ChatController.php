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

        /*if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }*/
    }



    public function ShowChat($idReceiver)
    {
        $messageDAO = new MessageDAO;
        $userDAO = new UserDAO;

        $sended = array();
        $received = array();
        $total = array();

        $me = $userDAO->GetById($_SESSION["id"]);

        $you = $userDAO->GetById($idReceiver);

        $meName = $me->getName() . " " . $me->getLast_name();

        $youName = $you->getName() . " " . $you->getLast_name();

        $total = $messageDAO->GetByIdsV2($_SESSION["id"], $idReceiver);

        if ($_SESSION["type"] == "guardian") {
            $backLink = FRONT_ROOT . "Guardian/HomeGuardian";
            $receiverLink = FRONT_ROOT . "Guardian/ViewOwnerProfile?id=" . $you->getId();
            $reservationsLink = FRONT_ROOT . "Guardian/ViewReservations";
        } else {
            $backLink = FRONT_ROOT . "Owner/HomeOwner";
            $receiverLink = FRONT_ROOT . "Owner/ViewGuardianProfile?id=" . $you->getId();
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
    }

    public function sendMessage($description, $userId)
    {
        $messageDAO = new MessageDAO;

        $message = new Message;

        $message->setDescription($description);
        $message->setReceiver($userId);
        $message->setSender($_SESSION["id"]);
        //$message->setDate(date("Y-m-d-H-i-s") );

        $messageDAO->Add($message);

        header("location: " . FRONT_ROOT . "Chat/ShowChat" . "?id=" . $userId);
    }
}
