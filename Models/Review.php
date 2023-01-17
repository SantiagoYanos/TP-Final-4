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


  /**
   * Get the value of id
   */ 
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of comment
   */ 
  public function getComment()
  {
    return $this->comment;
  }

  /**
   * Set the value of comment
   *
   * @return  self
   */ 
  public function setComment($comment)
  {
    $this->comment = $comment;

    return $this;
  }

  /**
   * Get the value of rating
   */ 
  public function getRating()
  {
    return $this->rating;
  }

  /**
   * Set the value of rating
   *
   * @return  self
   */ 
  public function setRating($rating)
  {
    $this->rating = $rating;

    return $this;
  }

  /**
   * Get the value of ownerId
   */ 
  public function getOwnerId()
  {
    return $this->ownerId;
  }

  /**
   * Set the value of ownerId
   *
   * @return  self
   */ 
  public function setOwnerId($ownerId)
  {
    $this->ownerId = $ownerId;

    return $this;
  }

  /**
   * Get the value of guardianId
   */ 
  public function getGuardianId()
  {
    return $this->guardianId;
  }

  /**
   * Set the value of guardianId
   *
   * @return  self
   */ 
  public function setGuardianId($guardianId)
  {
    $this->guardianId = $guardianId;

    return $this;
  }

  /**
   * Get the value of date
   */ 
  public function getDate()
  {
    return $this->date;
  }

  /**
   * Set the value of date
   *
   * @return  self
   */ 
  public function setDate($date)
  {
    $this->date = $date;

    return $this;
  }

  /**
   * Get the value of owner_name
   */ 
  public function getOwner_name()
  {
    return $this->owner_name;
  }

  /**
   * Set the value of owner_name
   *
   * @return  self
   */ 
  public function setOwner_name($owner_name)
  {
    $this->owner_name = $owner_name;

    return $this;
  }
}
