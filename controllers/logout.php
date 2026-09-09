<?php

use AuthorizationSystem\Session;

if (is_authorized() === false) {
    
    header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/login/");
    exit();
}

$request = $_REQUEST;

if ($request["mode"] == "logout") {

    try {

        $Session = new Session();
        $Session->clear();

        header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/login/");

    } catch (Exception $e) {

        $errorText = $e->getMessage() . "\n";
    } 
} 

header("Location: main/");
