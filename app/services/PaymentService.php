<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Payment;
use \App\Models\PaymentType;

class PaymentService extends BaseService {
  public function getPaymentTypes() {
    return $this->ExecuteAndMap(
      'SELECT * FROM ' . $this->getDbPrefix() . 'PaymentType',
      [],
      PaymentType::class
    );
  }

  public function getPayment($id) {
    return $this->findAndMap(
      'SELECT * FROM ' . $this->getDbPrefix() . 'Payment WHERE payid = ?',
      [$id],
      Payment::class
    );
  }

  public function createCashPayment($amount, $employee, $customer) {
    $this->createPayment($amount, $employee, $customer, 1);
    $id = $this->pdo->lastInsertId();
    
    $query = $this->execute(
      'INSERT INTO ' . $this->getDbPrefix() . 'Cash
        (payid)
      VALUES
        (?)',
      [$id]
    );

    return $this->getPayment($id);
  }

  private function createPayment($amount, $employee, $customer, $type) {
    return $this->execute(
      'INSERT INTO ' . $this->getDbPrefix() . 'Payment
        (amount, empnin, custid, pstatusid, ptid)
      VALUES
        (?, ?, ?, 1, ?)',
      [$amount, $employee->getNiNumber(), $customer->getId(), $type]
    );
  }
}
