<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Payment {
  private $payid;
  private $amount;
  private $paydatetime;
  private $empnin;
  private $empname;
  private $custid;
  private $custname;
  private $pstatusid;
  private $pdescription;
  private $ptid;
  private $ptdescription;

  public function getId() {
      return $this->payid;
  }

  public function getAmount() {
      return $this->amount;
  }

  public function getEmployeeNiNumber() {
      return $this->empnin;
  }

  public function getEmployeeName() {
    return $this->empname;
  }

  public function getPaymentType() {
      return $this->ptdescription;
  }

  public function getDateTime() {
      return $this->paydatetime;
  }

  public function getPaymentStatus() {
      return $this->pdescription;
  }

  public function getCustomerId() {
      return $this->custid;
  }

  public function getCustomerName() {
      return $this->custname;
  }
}
