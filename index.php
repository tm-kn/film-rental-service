<?php

define('IN_APP', 1);

require_once('app/bootstrap.php');

use \App\Middleware;

echo (new Middleware)->dispatch();
