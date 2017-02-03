<?php

define('IN_APP', 1);

require_once('app/bootstrap.php');

use \App\Middleware;

define('SHOP_ID', 1);

echo (new Middleware)->dispatch();
