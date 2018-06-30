<?php

session_start();

require_once "vendor/autoload.php";
require_once "config/routing.php";

include "config/config.php";

use App\src\core\Page;

# Get the request
$request = \App\src\core\Request::init();


# Initialize the page
$page = new Page($request);
