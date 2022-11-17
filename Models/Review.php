<?php

namespace Models;
class Review
{
  private $id;
  private $email_owner;
  private $email_guardian;
  private $date;
  private $comment;
  private $rating;

  public function getEmail_owner()
  {
    return $this->email_owner;
  }

  public function setEmail_owner($email_owner)
  {
    $this->email_owner = $email_owner;

    return $this;
  }

  public function getEmail_guardian()
  {
    return $this->email_guardian;
  }

  public function setEmail_guardian($email_guardian)
  {
    $this->email_guardian = $email_guardian;

    return $this;
  }

  public function getDate()
  {
    return $this->date;
  }

  public function setDate($date)
  {
    $this->date = $date;

    return $this;
  }

  public function getComment()
  {
    return $this->comment;
  }

  public function setComment($comment)
  {
    $this->comment = $comment;

    return $this;
  }

  public function getRating()
  {
    return $this->rating;
  }

  public function setRating($rating)
  {
    $this->rating = $rating;

    return $this;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }
}
