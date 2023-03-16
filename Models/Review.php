<?php

namespace Models;

class Review
{
  private $id;
  private $comment;
  private $rating;
  private $ownerId;
  private $guardianId;
  private $date;
  private $owner_name;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;

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

  public function getOwnerId()
  {
    return $this->ownerId;
  }

  public function setOwnerId($ownerId)
  {
    $this->ownerId = $ownerId;

    return $this;
  }

  public function getGuardianId()
  {
    return $this->guardianId;
  }

  public function setGuardianId($guardianId)
  {
    $this->guardianId = $guardianId;

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

  public function getOwner_name()
  {
    return $this->owner_name;
  }

  public function setOwner_name($owner_name)
  {
    $this->owner_name = $owner_name;

    return $this;
  }
}
