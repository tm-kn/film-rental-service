<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Shop {
    private $shopid;
    private $shopname;
    private $shopstreet;
    private $shopcity;
    private $shoppostcode;
    private $shopphone;

    public function getId() {
        return $this->shopid;
    }

    public function getName() {
        return $this->shopname;
    }
}
