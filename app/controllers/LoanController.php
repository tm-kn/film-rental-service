<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Services\LoanService;

class LoanController extends BaseController {
  private $loanService;

  public function __construct() {
    $this->loanService = new LoanService;
  }

  public function get($request) {
    if($request->getData('id')) {
      return $this->detail($request);
    }

    $loans = $this->loanService->getLoans($this->getCurrentUser()->getShopId());

    return $this->render('loan-list.php', ['ctrl' => $this, 'loans' => $loans]);
  }

  public function detail($request) {
    return $this->render('loan-detail.php', ['ctrl' => $this]);
  }

  public function new($request) {
    return $this->render('loan-new.php', ['ctrl' => $this]);
  }

  public function post($request) {
    $this->redirectTo('/loans/');
  }
}
