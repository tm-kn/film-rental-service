<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Payment;
use \App\Models\PaymentType;

class PaymentService extends BaseService {
  public function getPaymentTypes() {
    return $this->executeAndMap(
      'SELECT * FROM ' . $this->getDbPrefix() . 'PaymentType',
      [],
      PaymentType::class
    );
  }

  public function getPaymentsForLoan($dvdid, $retdatetime) {
    return $this->executeAndMap(
      'SELECT p.*, pt.ptdescription, ps.pdescription, emp.empname, cust.custname
      FROM ' . $this->getDbPrefix() . 'Payment p
      LEFT JOIN ' . $this->getDbPrefix() . 'FilmRental r USING(payid)
      LEFT JOIN ' . $this->getDbPrefix() . 'PaymentType pt USING(ptid)
      LEFT JOIN ' . $this->getDbPrefix() . 'PaymentStatus ps USING(pstatusid)
      LEFT JOIN ' . $this->getDbPrefix() . 'Employee emp ON (p.empnin = emp.empnin)
      LEFT JOIN ' . $this->getDbPrefix() . 'Customer cust ON (p.custid = cust.custid)
      WHERE r.dvdid = ? AND r.retdatetime = ? AND r.shopid = ?
      ORDER BY p.paydatetime',
      [$dvdid, $retdatetime, SHOP_ID],
      Payment::class
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

  public function createChequePayment($amount, $employee, $customer, $chequeno, $bankno, $bankname) {
    $this->createPayment($amount, $employee, $customer, 2);
    $id = $this->pdo->lastInsertId();
    
    $query = $this->execute(
      'INSERT INTO ' . $this->getDbPrefix() . 'Cheque
        (payid, chequeno, bankno, bankname)
      VALUES
        (?, ?, ?, ?)',
      [$id, $chequeno, $bankno, $bankname]
    );

    return $this->getPayment($id);
  }

  public function createDebitCardPayment($amount, $employee, $customer, $dcno, $dctype, $dcexpr) {
    $this->createPayment($amount, $employee, $customer, 3);
    $id = $this->pdo->lastInsertId();
    
    $query = $this->execute(
      'INSERT INTO ' . $this->getDbPrefix() . 'DebitCard
        (payid, dcno, dctype, dcexpr)
      VALUES
        (?, ?, ?, ?)',
      [$id, $dcno, $dctype, $dcexpr]
    );

    return $this->getPayment($id);
  }

  public function CreateCreditCardPayment($amount, $employee, $customer, $ccno, $cctype, $ccexpr) {
    $this->createPayment($amount, $employee, $customer, 4);
    $id = $this->pdo->lastInsertId();
    
    $query = $this->execute(
      'INSERT INTO ' . $this->getDbPrefix() . 'CreditCard
        (payid, ccno, cctype, ccexpr)
      VALUES
        (?, ?, ?, ?)',
      [$id, $ccno, $cctype, $ccexpr]
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
