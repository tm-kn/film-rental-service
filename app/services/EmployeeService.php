<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

use \App\Models\Employee;

class EmployeeService extends BaseService {
  public function getEmployees() {
    return $this->executeAndMap('SELECT * FROM ' . $this->getDbPrefix() . 'Employee', [], Employee::class);
  }

  public function getEmployee($empnin) {
    $results = $this->executeAndMap('SELECT * FROM ' . $this->getDbPrefix() . 'Employee WHERE empnin = ?', [$empnin], Employee::class);

    if(is_array($results) && count($results) > 0) {
      return $results[0];
    }

    return NULL;
  }
}
