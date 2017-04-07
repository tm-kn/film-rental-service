<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Customer {
  private $custid;
  private $custname;
  private $custstreet;
  private $custcity;
  private $custpostcode;
  private $custphone;
  private $regdate;
  private $endreg;
  private $shopid;
 
  public function getId() {
    return $this->custid;
  }

  public function getName() {
    return $this->custname;
  }
}
