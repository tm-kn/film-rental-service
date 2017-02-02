<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

class LoginController extends BaseController {
  public function get($request) {
    return $this->render('login.php', ['test' => 'blabla', 'testArray' => [1, 2, 3]]);
  }
}
