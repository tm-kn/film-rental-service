<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Services\EmployeeService;

class HomeController extends BaseController {
  public function get($request) {
    if($this->isLoggedIn()) {
      return $request->redirectTo('/loans/');
    } else {
      return $request->redirectTo('/login/');
    }
  }
}
