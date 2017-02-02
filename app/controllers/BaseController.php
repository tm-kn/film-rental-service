<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

use \Lib\Template;

abstract class BaseController {
  protected function getBaseTemplate($content) {
    $baseTemplate = new Template('base.php');

    $context = [
      'content' => $content,
      'title' => 'Film Rental Service'
    ];

    return $baseTemplate->render($context);
  }

  protected function render($file, $args = []) {
    $template = new Template($file);
    $content = $template->render($args);

    return $this->getBaseTemplate($content);
  }
}
