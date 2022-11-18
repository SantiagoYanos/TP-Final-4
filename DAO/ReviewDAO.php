<?php
    namespace DAO;

    use DAO\IReviewDAO as IReviewDAO;
    use Models\Review as Review;
    

    class ReviewDAO implements IReviewDAO
    {
        private $reviewList = array();
        private $fileName = ROOT."Data/reviews.json";

        function Add(review $review)
        {
            $this->RetrieveData();

            $review->setId($this->GetNextId());

            array_push($this->reviewList, $review);

            $this->SaveData();
        }

        function GetAll()
        {
            $this->RetrieveData();

            return $this->reviewList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $reviews = array_filter($this->reviewList, function($review) use($id){
                return $review->getId() == $id;
            });

            $reviews = array_values($reviews); //Reorderding array

            return (count($reviews) > 0) ? $reviews[0] : null;
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->reviewList = array_filter($this->reviewList, function($review) use($id){
                return $review->getId() != $id;
            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
             $this->reviewList = array();

             if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);

                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 
                 foreach($contentArray as $content)
                 {
                                    
                     

                     $review = new Review();
                     $review ->setId($content["id"]);
                     $review ->setEmail_owner($content["email_owner"]);
                     $review ->setEmail_guardian($content["email_guardian"]);
                     $review ->setDate($content["date"]);                       
                     $review ->setComment($content["comment"]);
                     $review ->setRating($content["rating"]);                     
                     array_push($this->reviewList, $review);
                 }
             }
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->reviewList as $review)
            {
                $valuesArray = array();
                $valuesArray["id"] = $review->getId();
                $valuesArray["email_owner"] = $review->getEmail_owner();
                $valuesArray["email_guardian"] = $review->getEmail_guardian();
                $valuesArray["date"] = $review->getDate();
                $valuesArray["phone"] = $review->getPhone();
                $valuesArray["comment"] = $review->getComment();
                $valuesArray["rating"] = $review->getRating();
                array_push($arrayToEncode, $valuesArray);
            }

            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId()
        {
            $id = 0;

            foreach($this->reviewList as $review)
            {
                $id = ($review->getId() > $id) ? $review->getId() : $id;
            }

            return $id + 1;
        }
    }
