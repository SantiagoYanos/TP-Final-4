<?php
    namespace DAO;

    use DAO\IGuardianDAO as IGuardianDAO;
    use Models\Guardian as Guardian;
    

    class GuardianDAO implements IGuardianDAO
    {
        private $guardianList = array();
        private $fileName = ROOT."Data/guardians.json";

        function Add(guardian $guardian)
        {
            $this->RetrieveData();

            $guardian->setId($this->GetNextId());

            array_push($this->guardianList, $guardian);

            $this->SaveData();
        }

        function GetAll()
        {
            $this->RetrieveData();

            return $this->guardianList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $guardians = array_filter($this->guardianList, function($guardian) use($id){
                return $guardian->getId() == $id;
            });

            $guardians = array_values($guardians); //Reorderding array

            return (count($guardians) > 0) ? $guardians[0] : null;
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->guardianList = array_filter($this->guardianList, function($guardian) use($id){
                return $guardian->getId() != $id;
            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
             $this->guardianList = array();

             if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);

                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 
                 foreach($contentArray as $content)
                 {
                                    
                     

                     $guardian = new guardian();
                     $guardian ->setId($content["id"]);
                     $guardian ->setCuil($content["cuil"]);
                     $guardian ->setName($content["name"]);
                     $guardian ->setAdress($content["adress"]);                       
                     $guardian ->setPhone($content["phone"]);
                     $guardian ->setPrefered_size($content["prefered_size"]);                     
                     $guardian ->setPrice($content["price"]);
                     $guardian ->setReputation($content["reputation"]);
                     $guardian ->setEmail($content["email"]);
                     $guardian ->setPassword($content["password"]);
                     $guardian ->setAvailable_date($content["available_date"]);

                     array_push($this->guardianList, $guardian);
                 }
             }
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->guardianList as $guardian)
            {
                $valuesArray = array();
                $valuesArray["id"] = $guardian->getId();
                $valuesArray["cuil"] = $guardian->getCuil();
                $valuesArray["name"] = $guardian->getName();
                $valuesArray["adress"] = $guardian->getAdress();
                $valuesArray["phone"] = $guardian->getPhone();
                $valuesArray["prefered_size"] = $guardian->getPrefered_size();
                $valuesArray["reputation"] = $guardian->getReputation();
                $valuesArray["price"] = $guardian->getPrice();
                $valuesArray["email"] = $guardian->getEmail();
                $valuesArray["password"] = $guardian->getPassword();
                $valuesArray["available_date"] = $guardian->getAvailable_date();
                array_push($arrayToEncode, $valuesArray);
            }

            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId()
        {
            $id = 0;

            foreach($this->guardianList as $guardian)
            {
                $id = ($guardian->getId() > $id) ? $guardian->getId() : $id;
            }

            return $id + 1;
        }
    }
?>