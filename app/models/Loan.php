<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Loan {
  private $shopid;

  public function getShopId() {
    return $this->shopid;
  }
}
