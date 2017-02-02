<?php namespace App\Models;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

class User {
  private $nin;
  private $name;

  public function __construct($nin, $name) {
    $this->nin = $nin;
    $this->name = $name;
  }
}
