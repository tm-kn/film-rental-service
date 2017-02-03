<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Loan;

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
    ORDER BY r.duedate ASC, r.dvdid ASC', [], Loan::class);
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

  public function acceptReturn($loan, $date) {
    $query = $this->execute(
      'UPDATE ' . $this->getDbPrefix() . 'FilmRental
      SET rstatusid = 2, retdatetime = ?
      WHERE dvdid = ? AND retdatetime =? AND rstatusid <> 2',
      [$date, $loan->getDvdId(), $loan->getReturnDateTime()]
    );

    return $query->rowCount();
  }
}
