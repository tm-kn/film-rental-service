<?php namespace App;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

use \App\Controllers\LoginController;
use \App\Controllers\HomeController;
use \Lib\Route;


function getRoutes() {
  $routes = [
    new Route('/', 'GET', HomeController::class),
    new Route('/login/', 'GET', LoginController::class)
  ];

  return $routes;
}
