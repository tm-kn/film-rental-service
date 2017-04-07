<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Customer;
use \App\Models\Employee;
use \App\Models\Loan;
use \App\Models\Dvd;
use \App\Models\Payment;

class LoanService extends BaseService {
  public function getLoans($includeReturned = false) {
    if($includeReturned) {
      $rstatusid = [1, 2, 3];
    } else {
      $rstatusid = [1, 3];
    }

    return $this->executeAndMap('
    SELECT r.*, f.filmtitle, rs.rdescription, c.custname
    FROM ' . $this->getDbPrefix() . 'FilmRental r
    LEFT JOIN ' . $this->getDbPrefix() . 'Film f USING(filmid)
    LEFT JOIN ' . $this->getDbPrefix() . 'RentalStatus rs USING(rstatusid)
    LEFT JOIN ' . $this->getDbPrefix() . 'Customer c USING(custid)
    WHERE r.shopid = ' . SHOP_ID .' AND r.rstatusid IN ('. join(", ", $rstatusid) . ')
    ORDER BY r.duedate DESC, r.dvdid ASC', [], Loan::class);
  }

  public function getLoan($dvdId, $retDateTime) {
    return $this->findAndMap(
      'SELECT r.*, f.filmtitle, rs.rdescription, c.custname
      FROM ' . $this->getDbPrefix() . 'FilmRental r
      LEFT JOIN ' . $this->getDbPrefix() . 'Film f USING(filmid)
      LEFT JOIN ' . $this->getDbPrefix() . 'RentalStatus rs USING(rstatusid)
      LEFT JOIN ' . $this->getDbPrefix() . 'Customer c USING(custid)
      WHERE r.shopid = ' . SHOP_ID .' AND dvdid = ? AND retdatetime = ?',
      [$dvdId, $retDateTime],
      Loan::class
    );
  }

  public function isOnLoan($dvdId) {
    $query = $this->execute(
      'SELECT COUNT(*)
      FROM ' . $this->getDbPrefix() . 'FilmRental
      WHERE rstatusid IN (1, 3) AND dvdid = ? AND shopid = ?',
      [$dvdId, SHOP_ID]
    );

    return (bool) $query->fetchColumn();
  }

  public function acceptReturn($loan, $date) {
    $query = $this->execute(
      'UPDATE ' . $this->getDbPrefix() . 'FilmRental
      SET rstatusid = 2, retdatetime = ?
      WHERE dvdid = ? AND retdatetime =? AND rstatusid <> 2',
      [$date, $loan->getDvdId(), $loan->getReturnDateTime()]
    );

    return $query->rowCount();
  }

  public function createLoan($dvd, $customer, $employee, $payment) {
    if (!$dvd instanceof Dvd) {
      throw new \Exception('$dvd has to be of instance of ' . Dvd::class . '.');
    }

    if (!$customer instanceof Customer) {
      throw new \Exception('$customer has to be of instance of ' . Customer::class . '.');
    }

    if (!$employee instanceof Employee) {
      throw new \Exception('$employee has to be of instance of ' . Employee::class . '.');
    }

    if (!$payment instanceof Payment) {
      throw new \Exception('$payment has to be of instance of ' . Payment::class . '.');
    }
    
    $query = $this->execute(
      'INSERT INTO ' . $this->getDbPrefix() . 'FilmRental
        (dvdid, filmid, custid, empnin, rstatusid, shopid, duedate, payid, rentalrate, overduecharge)
      VALUES
        (?, ?, ?, ?, 1, ' . SHOP_ID . ', DATE_ADD(NOW(), INTERVAL 7 DAY), ?, ?, \'0\')',
      [$dvd->getId(), $dvd->getFilmId(), $customer->getId(), $employee->getNiNumber(), $payment->getId(), $payment->getAmount()]
    );

    if (!$query->rowCount()) {
      return NULL;
    }

    return $this->getLoan($dvd->getId(), '0000-00-00');
  }
}
