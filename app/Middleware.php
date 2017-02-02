<?php namespace App;

if(!defined('IN_APP')) {
  throw new Exception("IN_APP not defined.");

}
use getRoutes;

class Middleware {
  private $request;
  private $request_method;
  private $routes;

  public function __construct() {
    $this->request = $_REQUEST;
    $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
    $this->routes = getRoutes();

    if(!array_key_exists('path', $this->request)) {
      $this->redirectToRoot();
    }

    $this->appendSlashToPath();
  }

  public function dispatch() {
    $route = $this->getCurrentRoute();

    $controller = (new \ReflectionClass($route->getController()))->newInstance();

    $controllerMethod = $route->getControllerMethod();

    return $controller->$controllerMethod($this);
  }

  private function getCurrentRoute() {
    foreach($this->routes as $route) {
      if($route->getPath() == $this->request['path'] && $route->getHttpMethod() == $this->requestMethod) {
        return $route;
      }
    }

    http_response_code(404);
    die("Not found - 404");
  }

  private function appendSlashToPath() {
    if(substr($this->request['path'], -1) != '/') {
      header('Location: index.php?path=' . $this->request['path'] . '/');
      die();
    }
  }

  private function redirectToRoot() {
    header('Location: index.php?path=/');
    die();
  }
}
