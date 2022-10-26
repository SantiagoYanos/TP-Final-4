<?php
    namespace SQLDAO;

    use \Exception as Exception;
    use SQLDAO\IOwnerSQLDAO as IOwnerSQLDAO;
    use Models\Owner as Owner;
    use SQLDAO\Connection as Connection;

    class OwnerSQLDAO implements IOwnerSQLDAO
    {
        private $OwnerSQLList = array();
        private $connection;
        private $tableName = "owners";

        function removeElementWithValue($array, $key, $value){
            foreach($array as $subKey => $subArray){
                 if($subArray[$key] == $value){
                      unset($array[$subKey]);
                 }
            }
            return $array;
       }

       public function activateFromBDD($OwnerSQL)
        {
            try
            {
                $query  = "UPDATE " . $this->tableName . " SET active ='" . 1 . "' where owner_id =" . $OwnerSQL->getOwnerSQLId();
                
                $this->connection  = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query);
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }

       public function deleteFromBDD($OwnerSQL)
        {
            try
            {
                $query  = "UPDATE " . $this->tableName . " SET active ='" . 0 . "' where owner_id =" . $OwnerSQL->getOwnerSQLId();
                
                $this->connection  = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query);
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }

        //!comentar json
        public function delete(Owner $OwnerSQL2)
        {
            $i=0;
            $this->RetrieveData();
            foreach($this->OwnerSQLList as $OwnerSQL)
            {
                if($OwnerSQL->getOwnerSQLId() == $OwnerSQL2->getId())
                {
                    echo var_dump($OwnerSQL2->getId());
                    unset($this->OwnerSQLList[$i]);
                }
                $i++;
            }
            $this->SaveData();
        }

        public function editBDD(Owner $OwnerSQL)
        {
            try
            {
                $query1  = "UPDATE " . $this->tableName . " SET name='" . $OwnerSQL->getName() . "' where owner_id = " . $OwnerSQL->getId();
                $query2  = "UPDATE " . $this->tableName . " SET email ='" . $OwnerSQL->getEmail() . "' where owner_id =" . $OwnerSQL->getId();
                $query3  = "UPDATE " . $this->tableName . " SET phone ='" . $OwnerSQL->getPhone() . "' where owner_id =" . $OwnerSQL->getId();
                $query4  = "UPDATE " . $this->tableName . " SET password ='" . $OwnerSQL->getPassword() . "' where owner_id =" . $OwnerSQL->getId();
                $query5  = "UPDATE " . $this->tableName . " SET last_name ='" . $OwnerSQL->getLast_name() . "' where owner_id =" . $OwnerSQL->getId();
                $query6  = "UPDATE " . $this->tableName . " SET adress ='" . $OwnerSQL->getAdress() . "' where owner_id =" . $OwnerSQL->getId();
                $query7  = "UPDATE " . $this->tableName . " SET dni ='" . $OwnerSQL->getDni() . "' where owner_id =" . $OwnerSQL->getId();
                $query8  = "UPDATE " . $this->tableName . " SET birht_date ='" . $OwnerSQL->getBirth_date() . "' where owner_id =" . $OwnerSQL->getId();
                
                $this->connection  = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query1);
                $this->connection->ExecuteNonQuery($query2);
                $this->connection->ExecuteNonQuery($query3);
                $this->connection->ExecuteNonQuery($query4);
                $this->connection->ExecuteNonQuery($query5);
                $this->connection->ExecuteNonQuery($query6);
                $this->connection->ExecuteNonQuery($query7);
                $this->connection->ExecuteNonQuery($query8);
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }

        public function editJSON(Owner $OwnerSQL2)
        {
            $this->RetrieveData();
            
            foreach($this->OwnerSQLList as $OwnerSQL)
            {
                if($OwnerSQL->getId() == $OwnerSQL2->getId())
                {
                    echo var_dump($OwnerSQL2->getId());
                    $OwnerSQL->setName($OwnerSQL2->getName());
                    $OwnerSQL->setEmail($OwnerSQL2->getEmail());
                    $OwnerSQL->setPhone($OwnerSQL2->getPhone());
                    /*$OwnerSQL->setactive($OwnerSQL2->getactive());*/
                    $OwnerSQL->setLast_name($OwnerSQL2->getLast_name());
                    $OwnerSQL->setAdress($OwnerSQL2->getAdress());
                    $OwnerSQL->setDni($OwnerSQL2->getDni());
                    $OwnerSQL->setBirth_date($OwnerSQL2->getBirth_date());
                    $OwnerSQL->setPassword($OwnerSQL2->getPassword());

                }
            }
            
            $this->SaveData();
        }
        
        public function Add(Owner $OwnerSQL)
        {
            $this->RetrieveData();

            try
            {
                $query = "INSERT INTO ".$this->tableName." (name, last_name, adress, dni, phone, email, password, birth_date) VALUES (:name, :last_name, :adress, :dni, :phone, :email, :password, :birth_date);";
                
                $parameters["name"] = $OwnerSQL->getName();
                $parameters["last_name"] = $OwnerSQL->getLast_name();
                $parameters["adress"] = $OwnerSQL->getAdress();
                $parameters["dni"] = $OwnerSQL->getDni();
                $parameters["phone"] = $OwnerSQL->getPhone();
                $parameters["email"] = $OwnerSQL->getEmail();
                $parameters["password"] = $OwnerSQL->getPassword();
                $parameters["birth_date"] = $OwnerSQL->getBirth_date();
                $parameters["active"] = true;
                

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }

            array_push($this->OwnerSQLList, $OwnerSQL);

            array_multisort($this->OwnerSQLList);

            $this->SaveData();
        }

        public function GetAllBDD()
        {
            try
            {
                $OwnerSQLList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $OwnerSQL = new Owner();
                    $OwnerSQL->setId($row["owner_id"]);
                    $OwnerSQL->setName($row["name"]);
                    $OwnerSQL->setLast_name($row["last_name"]);
                    $OwnerSQL->setAdress($row["adress"]);
                    $OwnerSQL->setDni($row["dni"]);
                    $OwnerSQL->setPhone($row["phone"]);
                    $OwnerSQL->setEmail($row["email"]);
                    $OwnerSQL->setPassword($row["password"]);
                    $OwnerSQL->setBirth_date($row["birth_date"]);
                  
                    array_push($OwnerSQLList, $OwnerSQL);
                }

                return $OwnerSQLList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetByIdBDD($id)
        {

            try
            {
                $query = "SELECT * FROM ". $this->tableName ." WHERE owner_id = " .$id. "and active = true";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {
                    $OwnerSQL = new Owner();
                    $OwnerSQL->setId($row["owner_id"]);
                    $OwnerSQL->setName($row["name"]);
                    $OwnerSQL->setLast_name($row["last_name"]);
                    $OwnerSQL->setAdress($row["adress"]);
                    $OwnerSQL->setDni($row["dni"]);
                    $OwnerSQL->setPhone($row["phone"]);
                    $OwnerSQL->setEmail($row["email"]);
                    $OwnerSQL->setPassword($row["password"]);
                    $OwnerSQL->setBirth_date($row["birth_date"]);

                    return $OwnerSQL;
                }
            }
            catch(Exception $ex)
            {
                throw $ex;
            }

            
        }

        public function GetByName($name) // app id
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName . ' WHERE name like "'.$name.'%" and active = true';

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query);

                foreach ($result as $row)
                {                
                    $OwnerSQL = new Owner();
                    $OwnerSQL->setId($row["owner_id"]);
                    $OwnerSQL->setName($row["name"]);
                    $OwnerSQL->setLast_name($row["last_name"]);
                    $OwnerSQL->setAdress($row["adress"]);
                    $OwnerSQL->setDni($row["dni"]);
                    $OwnerSQL->setPhone($row["phone"]);
                    $OwnerSQL->setEmail($row["email"]);
                    $OwnerSQL->setPassword($row["password"]);
                    $OwnerSQL->setBirth_date($row["birth_date"]);
                    
                }

                if($result != null)
                    return $OwnerSQL;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
        
        public function GetAll()
        {
            $this->RetrieveData();

            return $this->OwnerSQLList;
        }

        public function GetById ($id)
        {
            $this->RetrieveData();

            foreach($this->OwnerSQLList as $OwnerSQL)
            {
                if($OwnerSQL->getOwnerSQLId() == $id)
                {
                    return $OwnerSQL;
                }
            }
        }

        //!comentar
        public function Update($OwnerSQL)
        {
            $toUpdate = $this->GetById($OwnerSQL->getOwnerSQLId());

            $toUpdate->setId($OwnerSQL->getId());
            $toUpdate->setName($OwnerSQL->getName());
            $toUpdate->setEmail($OwnerSQL->getEmail());
            $toUpdate->setPhone($OwnerSQL->getPhone());
            /*$OwnerSQL->setactive($OwnerSQL->getactive());*/
            $toUpdate->setLast_name($OwnerSQL->getLast_name());
            $toUpdate->setAdress($OwnerSQL->getAdress());
            $toUpdate->setDni($OwnerSQL->getDni());
            $toUpdate->setBirth_date($OwnerSQL->getBirth_date());
            $toUpdate->setPassword($OwnerSQL->getPassword());
            
            $this->SaveData();

            return $OwnerSQL;
        }
        

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->OwnerSQLList as $OwnerSQL)
            {
                $valuesArray["owner_id"] = $OwnerSQL->getId();
                $valuesArray["name"] = $OwnerSQL->getName();
                $valuesArray["last_name"] = $OwnerSQL->getLast_name();
                $valuesArray["adress"] = $OwnerSQL->getAdress();
                $valuesArray["dni"] = $OwnerSQL->getDni();
                $valuesArray["phone"] = $OwnerSQL->getPhone();
                $valuesArray["email"] = $OwnerSQL->getEmail();
                $valuesArray["password"] = $OwnerSQL->getPassword();
                $valuesArray["birth_date"] = $OwnerSQL->getBirth_date();
                $valuesArray["active"] = true;

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            
            file_put_contents('Data/OwnerSQLs.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->OwnerSQLList = array();
            $arrayToDecode = array();

            if(file_exists('Data/OwnerSQLs.json'))
            {
                $jsonContent = file_get_contents('Data/OwnerSQLs.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $OwnerSQL = new Owner();
                    
                    $this->LoadInfo($OwnerSQL, $valuesArray);

                    array_push($this->OwnerSQLList, $OwnerSQL);
                }
            }
            $this->SaveData();
        }

        private function LoadInfo($OwnerSQL, $valuesArray)
        {
       
            $OwnerSQL->setId($valuesArray["owner_id"]);
            $OwnerSQL->setName($valuesArray["name"]);
            $OwnerSQL->setLast_name($valuesArray["last_name"]);
            $OwnerSQL->setAdress($valuesArray["adress"]);
            $OwnerSQL->setDni($valuesArray["dni"]);
            $OwnerSQL->setPhone($valuesArray["phone"]);
            $OwnerSQL->setEmail($valuesArray["email"]);
            $OwnerSQL->setPassword($valuesArray["password"]);
            $OwnerSQL->setBirth_date($valuesArray["birth_date"]);
            
            
        }
    }
?>