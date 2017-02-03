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
    new Route('/loans/new/', 'GET', LoanController::class, 'new'),
    new Route('/loans/', 'POST', LoanController::class),
  ];

  return $routes;
}
