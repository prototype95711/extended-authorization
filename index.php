<?php

use AuthorizationSystem\Router;
use AuthorizationSystem\Template;

$pathToFile = dirname(__FILE__);

require("{$pathToFile}/vendor/autoload.php");

$Router = new Router();

$currentController = $Router->detectCurrentController();

Template::getSmarty()->assign('userType', get_current_user_type());

require_once($currentController);
