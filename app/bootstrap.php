<?php

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

define('__ROOT__', dirname(dirname(__FILE__)));

require_once(__ROOT__ . '/lib/utils.php');
require_once(__ROOT__ . '/lib/Route.php');
require_once(__ROOT__ . '/lib/Template.php');

require_once(__ROOT__ . '/app/Middleware.php');
require_once(__ROOT__ . '/app/routes.php');

require_once(__ROOT__ . '/app/controllers/BaseController.php');
require_once(__ROOT__ . '/app/controllers/LoanController.php');
require_once(__ROOT__ . '/app/controllers/LoginController.php');
require_once(__ROOT__ . '/app/controllers/LogoutController.php');
require_once(__ROOT__ . '/app/controllers/HomeController.php');

require_once(__ROOT__ . '/app/models/Employee.php');
require_once(__ROOT__ . '/app/models/Loan.php');

require_once(__ROOT__ . '/app/services/BaseService.php');
require_once(__ROOT__ . '/app/services/EmployeeService.php');
require_once(__ROOT__ . '/app/services/LoanService.php');

session_start();
