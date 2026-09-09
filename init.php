<?php

use AuthorizationSystem\Database;
use AuthorizationSystem\Template;

/* Database connect */
$databaseConfig = array(
    'user'    => DB_USER,
    'pass'    => DB_PASS,
    'db'      => DB_NAME,
    'default' => 1
);

Database::connect($databaseConfig);

/* Template Engine init */

Template::init();
Template::getSmarty()->assign('location', PROJECT_PROTOCOL . PROJECT_DOMAIN);
