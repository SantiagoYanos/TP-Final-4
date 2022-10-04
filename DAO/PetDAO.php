<?php
    namespace DAO;

    use DAO\IPetDAO as IPetDAO;
    use Models\Pet as Pet;
    
    class PetDAO implements IPetDAO
    {
        private $pet_list = array();
        private $file_name = ROOT . "Data/pet.json";

        function Add(pet $pet)
        {
            $this->RetrieveData();
            $pet->set_Id($this->getNextId());
            array_push($this->pet_list, $pet);
            $this->SaveData();
        }

        function GetAll(){
            $this->RetrieveData();
            return $this->pet_list;
        }

        function GetById($id)
        {
            $this->RetrieveData();
            $pets = array_filter($this->pet_list, function($pet) use($id){
                return $pet->getId() == $id;
            });

            $pets = array_values($pets);
            return (count($pets) > 0) ? $pets[0] : null;
        }

        function Remove($id){
            $this->RetrieveData();

            $this->pet_list = array_filter($this->pet_list, function($pet) use($id)
            {
                return $pet->getId() != $id;
            });
        }

        private function RetrieveData()
        {
            $this->pet_list = array();

            if(file_exists($this->fileName))
            {
                $jsonToDecode = file_get_contects($this->fileName);

                $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();

                foreach($contentArray as $content)
                {
                    $pet = new pet();
                    $pet->setId($content["id"]);
                    $pet->setName($content["name"]);
                    $pet->setSize($content["size"]);
                    $pet->setVaccination_plan($content["vaccination_plan"]);
                    $set->setObservation($content["observation"]);
                    $set->setBreed($content["breed"]);
                    $set->setGuardian_email($content["guardian_email"]);

                    array_push($this->pet_list, $pet);
                }

            }
        }

        private function SaveData(){
            $arrayToEncode = array();

            foreach($this->pet_list as $pet){
                $valuesArray = array();
                $valuesArray["id"] = $pet->getId();
                $valuesArray["name"] = $pet->getName();
                $valuesArray["size"] = $pet->getSize();
                $valuesArray["vaccination_plan"] = $pet->getGetVaccination();
                $valuesArray["observation"] = $pet->getObservation();
                $valuesArray["breed"] = $pet->getBreed();
                $valuesArray["guardian_email"] = $pet->getGuardianEmail();
                array_push($arrayToEncode, $valuesArray);
            }
            
            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);

        }


        private function GetNextId()
        {
            $id = 0;
            foreach($this->pet_list as $pet){
                $id = ($pet->getId() > $id) ? $pet->getId() : $id;
            }

            return $id + 1;
        }

    }
?>