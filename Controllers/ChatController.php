<?php

Namespace Controllers;

use SQLDAO\MessageDAO as MessageDAO;
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
        $messageDAO=new MessageDAO;

        $sended= array();
        $received= array();
        $total= array();

        $sended=$messageDAO->GetByIds($_SESSION["id"],$idReceiver);
        $received=$messageDAO->GetByIds($idReceiver,$_SESSION["id"]);

        $total = array_merge($sended, $received);

        usort($total, function($a, $b) {

            if ($a->getDate() == $b->getDate())
            {
                return 0;
            }
            return $a->getDate() < $b->getDate() ? -1 : 1;
        });

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