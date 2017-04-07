<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class SalesFiguresController extends BaseController {
  public function dispatch($request) {
    if(!$this->isLoggedIn()) {
      return $request->redirectTo('/login/');
    }
  }

  public function get($request) {
   return $this->render(
      $request,
      'sales-figures.php',
      ['ctrl' => $this, 'request' => $request]
   );
  }
}
