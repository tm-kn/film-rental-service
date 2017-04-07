<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Dvd {
  private $dvdid;
  private $filmid;
  private $shopid;
  private $stateid;
  private $filmtitle;
  private $filmdescription;

  public function getId() {
    return $this->dvdid;
  }

  public function getFilmId() {
    return $this->filmid;
  }

  public function getShopId() {
    return $this->shopid;
  }

  public function getStateId() {
      return $this->stateid;
  }

  public function getFilmTitle() {
    return $this->filmtitle;
  }

  public function getFilmDescription() {
    return $this->filmdescription;
  }
}
