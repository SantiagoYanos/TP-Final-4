<?php

namespace Models;
class Review
{
  private $id;
  private $email_owner;
  private $email_guardian;
  private $date;
  private $coment;
  private $rating;

  






  /**
   * Get the value of email_owner
   */ 
  public function getEmail_owner()
  {
    return $this->email_owner;
  }

  /**
   * Set the value of email_owner
   *
   * @return  self
   */ 
  public function setEmail_owner($email_owner)
  {
    $this->email_owner = $email_owner;

    return $this;
  }

  /**
   * Get the value of email_guardian
   */ 
  public function getEmail_guardian()
  {
    return $this->email_guardian;
  }

  /**
   * Set the value of email_guardian
   *
   * @return  self
   */ 
  public function setEmail_guardian($email_guardian)
  {
    $this->email_guardian = $email_guardian;

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
   * Get the value of coment
   */ 
  public function getComent()
  {
    return $this->coment;
  }

  /**
   * Set the value of coment
   *
   * @return  self
   */ 
  public function setComent($coment)
  {
    $this->coment = $coment;

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
}

?>