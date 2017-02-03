<?php namespace Lib;

use \Exception;

class Http404 extends Exception {
  public function __construct($message = '', $code = 0, Exception $previous = null) {
    $addmessage = '';

    if ($message) {
      $addmessage = ': ' . $message;
    }

    $message = 'HTTP 404 Not Found' . $addmessage;
    parent::__construct($message, $code, $previous);
  }
}
