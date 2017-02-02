<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Services\EmployeeService;

class LoginController extends BaseController {
  public function dispatch($request) {
    if($this->isLoggedIn()) {
      return $request->redirectToRoot();
    }
  }

  public function get($request) {
    return $this->render('login.php', ['test' => 'blabla', 'testArray' => [1, 2, 3]]);
  }

  public function post($request) {
    $employeeService = new EmployeeService;
    $employee = $employeeService->getEmployee($request->getData('empnin'));

    if($employee) {
      $_SESSION['empnin'] = $employee->getNiNumber();
      return $request->redirectToRoot();
    } else {
      $_SESSION['flash'] = 'Your credentials are invalid';
      return $request->redirectTo('/login/');
    }

  }
}
