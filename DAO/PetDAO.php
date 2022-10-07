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
                $jsonToDecode = file_get_contents($this->fileName);

                $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();

                foreach($contentArray as $content)
                {
                    $pet = jsonToPet($content);

                    array_push($this->pet_list, $pet);
                }
            }
        }

        private function jsonToPet($content)
        {
            $pet = new Pet();

            $pet->setId($content["id"]);
            $pet->setName($content["name"]);
            $pet->setSize($content["size"]);
            $pet->setVaccination_plan($content["vaccination_plan"]);
            $set->setObservation($content["observation"]);
            $set->setBreed($content["breed"]);
            $set->setGuardian_email($content["guardian_email"]);

            return $pet;
        }

        public function GetPetsByOwner($owner_email){
            $new_pet_list = array();

            $new_pet_list = array_filter($new_pet_list, function($pet) use($owner_email)
            {
                return $pet->getOwnerEmail() == $owner_email;
            });

            return $new_pet_list;
        }

        private function SaveData(){
            $arrayToEncode = array();

            foreach($this->pet_list as $pet){
                
                $petArray = PetToArray($pet);
                
                array_push($arrayToEncode, $petArray);
            }
            
            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);

        }

        private function PetToArray($pet)
        {
            $valuesPet = array();
            $valuesPet["id"] = $pet->getId();
            $valuesPet["name"] = $pet->getName();
            $valuesPet["size"] = $pet->getSize();
            $valuesPet["vaccination_plan"] = $pet->getGetVaccination();
            $valuesPet["observation"] = $pet->getObservation();
            $valuesPet["breed"] = $pet->getBreed();
            $valuesPet["guardian_email"] = $pet->getGuardianEmail();

            return $valuesPet;
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
