<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Employee {
  private $empnin;
  private $empname;
  private $shopid;
  private $transactionstoday;

  public function getNiNumber() {
    return $this->empnin;
  }

  public function getFullName() {
    return $this->empname;
  }

  public function getShopId() {
    return $this->shopid;
  }

  public function getTodayTransactions() {
    return $this->transactionstoday;
  }
}
