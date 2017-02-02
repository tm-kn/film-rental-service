<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \Lib\Template;
use \App\Services\EmployeeService;

abstract class BaseController {
  private $currentUser = NULL;

  protected function getBaseTemplate($content) {
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

  protected function render($file, $args = []) {
    $template = new Template($file);
    $content = $template->render($args);

    return $this->getBaseTemplate($content);
  }

  public function getCurrentUser() {
    if(!$this->currentUser && isset($_SESSION['empnin'])) {
      $employeeService = new EmployeeService;

      $this->currentUser = $employeeService->getEmployee($_SESSION['empnin']);
    }

    return $this->currentUser;
  }

  public function isLoggedIn() {
    return !empty($this->getCurrentUser());
  }

  public function dispatch($request) {

  }
}
