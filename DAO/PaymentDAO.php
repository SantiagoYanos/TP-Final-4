<?php
    namespace DAO;

    use DAO\IPaymentDAO as IPaymentDAO;
    use Models\Payment as Payment;

    class PaymentDAO implements IPaymentDAO{

        private $paymentList;
        private $fileName = FRONT_ROOT . "/Data/payments.json";

        function Add(Payment $payment)
        {
            $this->RetrieveData();

            $payment->setId($this->GetNextId());

            array_push($this->paymentList, $payment);

            $this->SaveData();
        }

        function GetAll()
        {
            $this->RetrieveData();

            return $this->paymentList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $payments = array_filter($this->paymentList, function($payment) use($id){
                return $payment->getId() == $id;
            });

            $payments = array_values($payments); //Reorderding array

            return (count($payments) > 0) ? $payments[0] : null;
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->paymentList = array_filter($this->paymentList, function($payment) use($id){
                return $payment->getId() != $id;
            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
             $this->paymentList = array();

             if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);

                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 
                 foreach($contentArray as $content)
                 {
                     $payment = new payment();
                     $payment ->setId($content["id"]);
                     $payment ->setAmount($content["amount"]);
                     $payment ->setDate($content["date"]);                     
                     $payment ->setPayment_method($content["payment_method"]);
                     $payment ->setGuardian_email($content["guardian_email"]);                     
                     $payment ->setOwner_email($content["owner_email"]);

                     array_push($this->paymentList, $payment);
                 }
             }
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->paymentList as $payment)
            {
                $valuesArray = array();
                $valuesArray["id"] = $payment->getId();
                $valuesArray["amount"] = $payment->getCuil();
                $valuesArray["date"] = $payment->getName();
                $valuesArray["adress"] = $payment->getAdress();
                $valuesArray["payment_method"] = $payment->getPhone();
                $valuesArray["guardian_email"] = $payment->getPrefered_size();
                $valuesArray["owner_email"] = $payment->getReputation();
              
                array_push($arrayToEncode, $valuesArray);
            }

            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId()
        {
            $id = 0;

            foreach($this->paymentList as $payment)
            {
                $id = ($payment->getId() > $id) ? $payment->getId() : $id;
            }

            return $id + 1;
        }

    }
