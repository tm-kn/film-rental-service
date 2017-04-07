<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Services\SalesFiguresService;

class SalesFiguresController extends BaseController {
  private $salesFiguresService;

  public function __construct() {
    $this->salesFiguresService = new SalesFiguresService;
  }

  public function dispatch($request) {
    if(!$this->isLoggedIn()) {
      return $request->redirectTo('/login/');
    }
  }

  public function get($request) {
   return $this->render(
      $request,
      'sales-figures.php',
      [
        'ctrl' => $this,
        'request' => $request,
        'totalPaymentsToday' => $this->salesFiguresService->getTotalPaymentsToday(),
        'dvdsRentedToday' => $this->salesFiguresService->getNumberOfDVDsRentedToday(),
        'dvdsReturnedToday' => $this->salesFiguresService->getNumberOfDVDsReturnedToday(),
        'mostTransactionsEmployeeToday' => $this->salesFiguresService->getEmployeeWithMostTransactionsToday()
      ]
   );
  }
}
