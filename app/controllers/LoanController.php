<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Services\LoanService;
use \Lib\Http404;

class LoanController extends BaseController {
  private $loanService;

  public function __construct() {
    $this->loanService = new LoanService;
  }

  public function get($request) {
    if($request->getData('dvdId') && $request->getData('retDateTime')) {
      return $this->detail($request);
    }

    $loans = $this->loanService->getLoans();

    return $this->render($request, 'loan-list.php', ['ctrl' => $this, 'loans' => $loans]);
  }

  public function detail($request) {
    $loan = $this->loanService->getLoan(
      $request->getData('dvdId'),
      $request->getData('retDateTime')
    );

    if(!$loan) {
      throw new Http404();
    }

    return $this->render($request, 'loan-detail.php', ['ctrl' => $this, 'loan' => $loan]);
  }

  public function newLoan($request) {
    return $this->render($request, 'loan-new.php', ['ctrl' => $this, 'request' => $request]);
  }

  public function post($request) {
    $errors = [];

    if(empty($request->getData('dvdid')) || empty($request->getData('custid'))) {
      $errors[] = 'All fields have to be filled in.';
    }

    if(count($errors)) {
      $_SESSION['flash'] = join('; ', $errors);
      return $this->render($request, 'loan-new.php', ['ctrl' => $this, 'request' => $request]);
    }

    $_SESSION['flash'] = 'Loaned a DVD out.';

    return $request->redirectTo('/loans/');
  }

  public function acceptReturnGet($request) {
    $loan = $this->loanService->getLoan(
      $request->getData('dvdId'),
      $request->getData('retDateTime')
    );

    if(!$loan || $loan->getStatusId() == 2) {
      throw new Http404();
    }

    return $this->render($request, 'loan-accept-return.php', ['ctrl' => $this, 'loan' => $loan]);
  }

  public function acceptReturnPost($request) {
    $loan = $this->loanService->getLoan(
      $request->getData('dvdId'),
      $request->getData('retDateTime')
    );

    if(!$loan || $loan->getStatusId() == 2) {
      throw new Http404();
    }

    // Set new date so we know the new primary key
    $date = date('Y-m-d');
    $result = $this->loanService->acceptReturn($loan, $date);

    if($result) {
      $_SESSION['flash'] = 'Accepted return';
    } else {
      $_SESSION['flash'] = 'Internal error. DVD could not be marked as returned.';
    }

    return $request->redirectTo('/loans/', ['dvdId' => $loan->getDvdId(), 'retDateTime' => $date]);
  }
}
