<?php namespace Lib;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");
}

define('TEMPLATES_DIRECTORY', '/app/templates/');

class Template {
  private $file;

  public function __construct($file) {
    $this->file = $file;
  }

  public function render($args = []) {
    if(is_array($args)) {
      extract($args);
    }

    ob_start();
    include(__ROOT__ . TEMPLATES_DIRECTORY . $this->file);
    $template = ob_get_clean();

    return $template;
  }
}
