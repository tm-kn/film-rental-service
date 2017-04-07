<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class PaymentType {
  private $ptid;
  private $ptdescription;
 
  public function getId() {
    return $this->ptid;
  }

  public function getName() {
    return $this->ptdescription;
  }
}
