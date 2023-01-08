<?php

namespace SQLDAO;

use \Exception as Exception;
use Models\message as Message;
use SQLDAO\Connection as Connection;

class MessageDAO
{
    private $MessageList = array();
    private $connection;
    private $tableName = "Messages";
    public function GetAll()
    {
        try {

            $MessageList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE active=true";

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {

                $MessageSQL = $this->LoadData($row);

                array_push($MessageList, $MessageSQL);
            }

            return $MessageList;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function Add(Message $MessageSQL)
    {
        try {
            $queryMessage = "insert into . $this->tableName . VALUES (:description, :sender_id, :receiver_id, :date);";

            $parametersMessage["description"] = $MessageSQL->getDescription();
            $parametersMessage["sender_id"] = $MessageSQL->getSender();
            $parametersMessage["receiver_id"] = $MessageSQL->getReceiver();
            $parametersMessage["date"] = $MessageSQL->getDate();
            
            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->ExecuteNonQuery($queryMessage, $parametersMessage);

            
            
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function LoadData($resultSet)
    {
        $MessageSQL = new Message();
        $MessageSQL->setId($resultSet["message_id"]);
        $MessageSQL->setDate($resultSet["date"]);
        $MessageSQL->setSender($resultSet["sender_id"]);
        $MessageSQL->setReceiver($resultSet["receiver_id"]);
        $MessageSQL->setDescription($resultSet["description"]);
        return $MessageSQL;
    }
    
    public function GetByIds($senderId, $receiverId)
    {
        try {
            $this->MessageList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE sender_id=:senderId AND receiver_id=:receiverId AND active=true ";

            $parameters["senderId"] = $senderId;
            $parameters["receiverId"] = $receiverId;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!$resultSet[0]) {
                return null;
            }

            $MessageSQL = $this->LoadData($resultSet[0]);

            return $MessageSQL;
        } catch (Exception $e) {
            throw $e;
        }
    }
}