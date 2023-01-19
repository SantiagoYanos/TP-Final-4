<?php

namespace Controllers;

use SQLDAO\ReviewDAO as ReviewDAO;
use Models\User as User;
use \Exception as Exception;
use Models\Review as Review;

class ReviewController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");

        /*if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }*/
    }


    public function ShowReviews($guardianId)
    {
        $reviewDAO = new ReviewDAO;
        $noreview=0;
        
        $total = $reviewDAO->GetById($guardianId);
        if(!$total)
        {
            $noreview=$guardianId;
        }

        return require_once(VIEWS_PATH . "view_reviewsV2.php");
    }

    public function makeReview($comment, $guardianId, $rating)
    {
        $reviewDAO = new ReviewDAO;

        $review = new Review;

        $review->setComment($comment);
        $review->setRating($rating);
        $review->setOwnerId($_SESSION["id"]);
        $review->setGuardianId($guardianId);

        $reviewDAO->Add($review);

        header("location: " . FRONT_ROOT . "Review/ShowReviews" . "/?id=" . $guardianId);
    }
}
