<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Loan {
  private $custid;
  private $custname;
  private $duedate;
  private $dvdid;
  private $filmid;
  private $filmtitle;
  private $overduecharge;
  private $rentalrate;
  private $retdatetime;
  private $shopid;
  private $rdescription;
  private $rstatusid;

  public function getCustomerName() {
    return $this->custname;
  }

  public function getCustomerId() {
    return $this->custid;
  }

  public function getDueDate() {
    return $this->duedate;
  }

  public function getDvdId() {
    return $this->dvdid;
  }

  public function getFilmId() {
    return $this->filmid;
  }

  public function getFilmName() {
    return $this->filmtitle;
  }

  public function getOverdueCharge() {
    return $this->overduecharge;
  }

  public function getRate() {
    return $this->rentalrate;
  }

  public function getReturnDateTime() {
    return $this->retdatetime;
  }

  public function getShopId() {
    return $this->shopid;
  }

  public function getStatus() {
    return $this->rdescription;
  }

  public function getStatusId() {
    return $this->rstatusid;
  }
}
