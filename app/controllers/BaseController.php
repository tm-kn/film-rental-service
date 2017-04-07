<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \Lib\Template;
use \App\Services\EmployeeService;
use \App\Services\ShopService;

class BaseController {
  private $currentUser = NULL;
  private $currentShop = NULL;

  protected function getBaseTemplate($request, $content) {
    $baseTemplate = new Template('base.php');

    $context = [
      'content' => $content,
      'title' => 'Film Rental Service',
      'error' => '',
      'ctrl' => $this
    ];

    if(isset($_SESSION['flash'])) {
      $context['error'] = $_SESSION['flash'];
      unset($_SESSION['flash']);
    }
    return $baseTemplate->render($context);
  }

  public function render($request, $file, $args = []) {
    $template = new Template($file);
    $content = $template->render($args);

    return $this->getBaseTemplate($request, $content);
  }

  public function getCurrentUser() {
    if(!$this->currentUser && isset($_SESSION['empnin'])) {
      $employeeService = new EmployeeService;

      $this->currentUser = $employeeService->getEmployee($_SESSION['empnin']);
    }

    return $this->currentUser;
  }

  public function getShop() {
    if(!$this->currentShop) {
      $shopService = new ShopService;

      $this->currentShop = $shopService->getShop(SHOP_ID);
    }

    return $this->currentShop;
  }

  public function isLoggedIn() {
    return !empty($this->getCurrentUser());
  }

  public function dispatch($request) {

  }
}
