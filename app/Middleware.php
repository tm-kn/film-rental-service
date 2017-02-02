<?php namespace App;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");

}
use getRoutes;

class Middleware {
  private $request;
  private $requestMethod;
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

    $controller->dispatch($this);
    return $controller->$controllerMethod($this);
  }

  public function getData($property) {
    if(array_key_exists($property, $this->request)) {
      return $this->request[$property];
    }

    return NULL;
  }

  private function getCurrentRoute() {
    foreach($this->routes as $route) {
      if($route->getPath() == $this->request['path'] && $route->getHttpMethod() == $this->requestMethod) {
        return $route;
      }
    }

    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    exit;
  }

  private function appendSlashToPath() {
    if(substr($this->request['path'], -1) != '/') {
      header('Location: index.php?path=' . $this->request['path'] . '/');
      exit;
    }
  }

  public function redirectTo($path) {
    header('Location: index.php?path=' . $path, true);
    exit;
  }

  public function redirectToRoot() {
    return $this->redirectTo('/');
  }
}
