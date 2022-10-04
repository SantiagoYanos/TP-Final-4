<?php

    namespace DAO;

    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Pet as Pet;

    use DAO\PetDAO as PetDAO;

    class OwnerDAO implements IOwnerDAO
    {
        private $ownerList = array();
        private $fileName = ROOT.'Data/owners.json';

        function Add(Owner $owner)
        {
            $this->RetrieveData();

            $owner->setId($this->GetNextId());

            array_push($this->ownerList, $owner);

            $this->SaveData();
        }

        function GetAll()
        {
            $this->RetrieveData();

            return $this->ownerList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $owners = array_filter($this->ownerList, function($owner) use ($id) {


                return $owner->getId() == $id;

            });

            $owners = array_values($this->ownerList);

            if(count($owners) > 0)
            {
                return $owners[0];
            }
            else
            {
                return null;
            }
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->ownerList = array_filter($this->ownerList, function($owner) use ($id){

                return $owner->getId() != $id;

            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
            $this->ownerList = array();

            if(file_exists($this->fileName))
            {
                $jsonToDecode = file_get_contents($this->fileName); //Agarra el contenido del json en formato String

                $contentArray = array();

                if($jsonToDecode) //Si el String tiene contenido...
                {
                    $contentArray = json_decode($jsonToDecode, true); //Transforma el String a formato Json
                }

                foreach($contentArray as $content) //Por cada owner del array de owners (que trajo del archivo)...
                {
                    $owner = jsonToOwner($content);

                    array_push($this->ownerList, $owner); //Agrega el owner a la lista de owners (ahora con formato Owner)
                }
            }
        }

        private function jsonToOwner($content)
        {
            $owner = new Owner(); //Crea un owner de tipo Owner

                    $owner->setId($content["id"]); //Le asigna los datos con los set
                    $owner->setName($content["name"]);
                    $owner->setDni($content["dni"]);
                    $owner->setPhone($content["phone"]);
                    $owner->setPets(PetDAO->GetPetsByOwner($content["email"])); //Ejecuta la función del DAO de Pets obteniendo todas las mascotas del dueño en formato Pet
                    $owner->setEmail($content["email"]);
                    $owner->setPassword($content["password"]);

            return $owner;
        }

        private function SaveData()
        {
            $arrayToDecode = array(); //Arreglo de arreglos (que después van a pasar a ser un Json)

            foreach($this->ownerList as $owner) //Por cada Owner de la lista de Owners...
            {
                $ownerArray = OwnerToArray($owner); //Pasa cada Owner a un Array

                array_push($arrayToDecode, $ownerArray); //Agrega al Array de Owners
                
            }

            $fileContent = json_encode($arrayToDecode, JSON_PRETTY_PRINT); //Lo transforma a formato JSON 

            file_put_contents($this->filename, $fileContent); //Lo carga en un archivo (o crea el archivo)
        }

        private function OwnerToArray($owner)
        {
            $valuesOwner = array();
            $valuesOwner["id"] = $owner.getId(); //Se pasa del Owner al array owner los datos
            $valuesOwner["name"] = $owner.getName();
            $valuesOwner["dni"] = $owner.getDni();
            $valuesOwner["phone"] = $owner.getPhone();
            $valuesOwner["pets"] = array();

            foreach($owner.getPets() as $pet)
            {
                $petArray = PetDAO->MascotToArray($pet);
                    
                array_push($valuesOwner["pets"], $petArray);
            }

            $valuesOwner["email"] = $owner.getEmail();
            $valuesOwner["passport"] = $owner.getPassport();

            return $valuesOwner;
        }

        private function GetNextId()
        {
            $id = 0;

            foreach($this->ownerList as $owner)
            {
                $id = ($owner->getId() > $id) ? $owner->getId() : $id;
            }

            return $id + 1;
        }

    }

?>