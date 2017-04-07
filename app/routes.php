<?php namespace App;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Controllers\LoanController;
use \App\Controllers\LoginController;
use \App\Controllers\LogoutController;
use \App\Controllers\HomeController;
use \Lib\Route;


function getRoutes() {
  $routes = [
    new Route('/', 'GET', HomeController::class),

    new Route('/login/', 'GET', LoginController::class),
    new Route('/login/', 'POST', LoginController::class),

    new Route('/logout/', 'GET', LogoutController::class),

    new Route('/loans/', 'GET', LoanController::class),
    new Route('/loans/new/', 'GET', LoanController::class, 'newLoan'),
    new Route('/loans/new/', 'POST', LoanController::class),
    new Route('/loans/new/payment/', 'GET', LoanController::class, 'getPaymentTypeForm'),
    new Route('/loans/new/payment/', 'POST', LoanController::class, 'postPaymentTypeForm'),
    new Route('/loans/new/payment/details/', 'GET', LoanController::class, 'getPaymentDetailsForm'),
    new Route('/loans/new/payment/details/', 'POST', LoanController::class, 'postPaymentDetailsForm'),

    new Route('/loans/accept-return/', 'GET', LoanController::class, 'acceptReturnGet'),
    new Route('/loans/accept-return/', 'POST', LoanController::class, 'acceptReturnPost'),
  ];

  return $routes;
}
