<?php namespace Lib;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

class Route {
  private $path;
  private $httpMethod;
  private $controller;
  private $controllerMethod;

  public function __construct($path, $httpMethod, $controller, $controllerMethod = NULL) {
    $this->path = $path;
    $this->controller = $controller;
    $this->httpMethod = strtoupper($httpMethod);

    $this->controllerMethod = $controllerMethod;

    if(empty($this->controllerMethod)) {
      $this->controllerMethod = strtolower($this->httpMethod);
    }
  }

  public function getController() {
    return $this->controller;
  }

  public function getControllerMethod() {
    return $this->controllerMethod;
  }

  public function getHttpMethod() {
    return $this->httpMethod;
  }

  public function getPath() {
    return $this->path;
  }
}
