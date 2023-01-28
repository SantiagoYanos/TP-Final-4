<?php

namespace Controllers;

use SQLDAO\ReviewDAO as ReviewDAO;
use SQLDAO\UserDAO as UserDAO;
use Models\User as User;
use \Exception as Exception;
use Models\Review as Review;

class ReviewController
{
    function __construct()
    {
        require_once(ROOT . "/Utils/validateSession.php");
        require_once(ROOT . "/Utils/encrypt.php");

        /*if ($_SESSION["type"] == "guardian") {
            header("location: " . FRONT_ROOT . "Guardian/HomeGuardian");
        }*/
    }


    public function ShowReviews($guardianId) //Encrypted
    {
        $reviewDAO = new ReviewDAO;
        $userDAO = new UserDAO;
        $noreview = 0;

        try {

            $encryptedId = $guardianId;

            $guardianId = decrypt($guardianId);

            $guardianId ? null : throw new Exception("Guardian not found");

            $guardian = $userDAO->GetById($guardianId);
            $total = $reviewDAO->GetById($guardianId);

            if ($_SESSION["type"] == "guardian") {
                $backLink = FRONT_ROOT . "Guardian/HomeGuardian";
            } else {
                $backLink = FRONT_ROOT . "Owner/ViewGuardianProfile";

                $ownerReview = $reviewDAO->GetByOwner($guardianId, $_SESSION["id"]);

                if ($ownerReview) {
                    $formLink = FRONT_ROOT . "Review/editReview";
                } else {
                    $formLink = FRONT_ROOT . "Review/makeReview";
                }
            }

            //return require_once(VIEWS_PATH . "view_reviewsV2.php");
            return require_once(VIEWS_PATH . "view_reviewsV3.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function makeReview($comment, $guardianId, $rating) //Encripted
    {
        $reviewDAO = new ReviewDAO;

        $review = new Review;

        try {

            $encryptedId = $guardianId;

            $guardianId = decrypt($guardianId);

            $guardianId ? null : throw new Exception("Guardian not found");

            $review->setComment($comment);
            $review->setRating($rating);
            $review->setOwnerId($_SESSION["id"]);
            $review->setGuardianId($guardianId);

            $reviewDAO->Add($review);

            header("location: " . FRONT_ROOT . "Review/ShowReviews" . "?id=" . $encryptedId);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editReview($comment, $guardianId, $rating, $oldReviewId) //Encrypted
    {
        $reviewDAO = new ReviewDAO;

        $review = new Review;

        try {

            $encryptedId = $guardianId;

            $guardianId = decrypt($guardianId);

            $oldReviewId = decrypt($oldReviewId);

            ($guardianId && $oldReviewId) ? null : throw new Exception("Guardian or Review not found");

            $review->setComment($comment);
            $review->setRating($rating);
            $review->setOwnerId($_SESSION["id"]);
            $review->setGuardianId($guardianId);

            $reviewDAO->EditReview($review, $oldReviewId);

            header("location: " . FRONT_ROOT . "Review/ShowReviews" . "?id=" . $encryptedId);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
