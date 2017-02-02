<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

use \App\Services\EmployeeService;

class HomeController extends BaseController {
  public function get($request) {
    $employeeService = new EmployeeService;

    $employees = $employeeService->getEmployees();

    return $this->render('home.php', ['ctrl' => $this, 'employees' => $employees]);
  }
}
