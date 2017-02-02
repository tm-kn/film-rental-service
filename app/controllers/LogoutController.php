<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

class LogoutController extends BaseController {
  public function dispatch($request) {
    if(!$this->isLoggedIn()) {
      return $request->redirectTo('/login/');
    }
  }

  public function get($request) {
    unset($_SESSION['empnin']);
    $_SESSION['flash'] = 'You have been logged out';
    return $request->redirectToRoot();
  }
}
