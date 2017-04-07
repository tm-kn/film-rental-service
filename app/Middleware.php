<?php namespace App;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");

}

use \Lib\Http404;
use \App\Controllers\BaseController;
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

    try {
      $controller->dispatch($this);
      return $controller->$controllerMethod($this);
    } catch(Http404 $e) {
      $this->handle404();
      exit;
    }
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

    $this->handle404();
    exit;
  }

  private function appendSlashToPath() {
    if(substr($this->request['path'], -1) != '/') {
      header('Location: index.php?path=' . $this->request['path'] . '/');
      exit;
    }
  }

  public function redirectTo($path, $args = []) {
    header('Location: ' . \Lib\url($path, $args));
    exit;
  }

  public function redirectToRoot() {
    return $this->redirectTo('/');
  }

  private function handle404() {
    $ctrl = new BaseController;
    echo $ctrl->render($this, '404.php', ['ctrl' => $ctrl]);
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    exit;
  }
}
