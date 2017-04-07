<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Payment {
  private $payid;
  private $amount;
  private $paydatetime;
  private $empnin;
  private $custid;
  private $pstatusid;
  private $ptid;

  public function getId() {
      return $this->payid;
  }

  public function getAmount() {
      return $this->amount;
  }
}
