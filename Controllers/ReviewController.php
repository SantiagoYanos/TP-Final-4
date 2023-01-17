<?php

namespace Controller;

use SQLDAO\MessageDAO as MessageDAO;
use Models\User as User;
use \Exception as Exception;
use Models\Message as Message;

class ReviewController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        /*if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }*/
    }


    public function ShowReviews($guardianid)
    {
        $messageDAO=new MessageDAO;
        return require_once(VIEWS_PATH . "PrettyChat.php");
    }

    public function sendMessage($description,$userId)
    {
        $messageDAO =new MessageDAO;

        $message= new Message;

        $message->setDescription($description);
        $message->setReceiver($userId);
        $message->setSender($_SESSION["id"]);
        //$message->setDate(date("Y-m-d-H-i-s") );
         
        $messageDAO->Add($message);


        header("location: " . FRONT_ROOT . "Chat/ShowChat" . "/?id=" . $userId);
    }
}