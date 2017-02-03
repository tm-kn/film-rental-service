<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Loan;

class LoanService extends BaseService {
  public function getLoans($shopid) {
    return $this->executeAndMap('SELECT * FROM ' . $this->getDbPrefix() . 'FilmRental WHERE shopid = ?', [$shopid], Loan::class);
  }
}
