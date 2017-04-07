<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Employee;

class SalesFiguresService extends BaseService {
  public function getTotalPaymentsToday() {
    $query = $this->execute(
      'SELECT SUM(p.amount)
      FROM ' . $this->getDbPrefix() .'Payment p
      LEFT JOIN ' . $this->getDbPrefix() .'Employee e USING(empnin)
      WHERE e.shopid = ? AND DATE(p.paydatetime) = CURRENT_DATE()',
      [SHOP_ID]
    );

    $count = $query->fetchColumn();

    return $count;
  }

  public function getNumberOfDVDsRentedToday() {
    $query = $this->execute(
      'SELECT COUNT(p.paydatetime)
      FROM ' . $this->getDbPrefix() .'Payment p
      LEFT JOIN ' . $this->getDbPrefix() .'Employee e USING(empnin)
      WHERE e.shopid = ? AND DATE(p.paydatetime) = CURRENT_DATE()',
      [SHOP_ID]
    );

    $count = $query->fetchColumn();

    return $count;
  }

  public function getNumberOfDVDsReturnedToday() {
    $query = $this->execute(
      'SELECT COUNT(retdatetime)
      FROM ' . $this->getDbPrefix() .'FilmRental
      WHERE shopid = ? AND DATE(retdatetime) = CURRENT_DATE()',
      [SHOP_ID]
    );

    $count = $query->fetchColumn();
    
    return $count;
  }

  public function getEmployeeWithMostTransactionsToday() {
    return $this->findAndMap(
      'SELECT e.*, COUNT(p.payid) as transactionstoday
      FROM ' . $this->getDbPrefix() . 'Payment p
      LEFT JOIN ' . $this->getDbPrefix() . 'Employee e USING(empnin)
      WHERE e.shopid = ' . SHOP_ID . ' AND DATE(p.paydatetime) = CURRENT_DATE()
      GROUP BY e.empnin
      ORDER BY transactionstoday DESC
      LIMIT 1',
      [],
      Employee::class
    );
  }
}
