<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Employee;

class EmployeeService extends BaseService {
  public function getEmployees() {
    return $this->executeAndMap('SELECT * FROM ' . $this->getDbPrefix() . 'Employee AND shopid = ' . SHOP_ID, [], Employee::class);
  }

  public function getEmployee($empnin) {
    return $this->findAndMap('SELECT * FROM ' . $this->getDbPrefix() . 'Employee WHERE empnin = ? AND shopid = ' . SHOP_ID, [$empnin], Employee::class);
  }
}
