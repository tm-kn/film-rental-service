<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Customer;

class CustomerService extends BaseService {
  public function getCustomers() {
    return $this->executeAndMap(
        'SELECT c.*, r.*
        FROM ' . $this->getDbPrefix() . 'Customer c
        LEFT JOIN ' . $this->getDbPrefix() . 'Register r USING(custid)
        WHERE r.shopid = ' . SHOP_ID,
        [],
        Customer::class
    );
  }

  public function getCustomer($id) {
    return $this->findAndMap(
        'SELECT c.*, r.*
        FROM ' . $this->getDbPrefix() . 'Customer c
        LEFT JOIN ' . $this->getDbPrefix() . 'Register r USING(custid)
        WHERE custid = ? AND r.shopid = ' . SHOP_ID,
        [$id],
        Customer::class
    );
  }
}
