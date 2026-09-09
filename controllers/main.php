<?php

use AuthorizationSystem\UserTypes;
use AuthorizationSystem\Template;

if (is_authorized() === false) {
    
    header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/login/");
    exit();
}

Template::getSmarty()->display('main.tpl');
