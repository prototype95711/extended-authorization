<?php

use AuthorizationSystem\UserRequest;
use AuthorizationSystem\Template;

if (is_authorized() === true) {
    header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/main/");
    exit();
}

$request = $_REQUEST;
$errorText = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($request["mode"] == "login") {

        try {

            $User = new UserRequest($request);
            $User->login();

            header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/main/");
    
        } catch (Exception $e) {
    
            $errorText = $e->getMessage() . "\n";
        } 
    }  
}

$notifions = get_notifions("login");

Template::getSmarty()->assign('notifions', $notifions);
Template::getSmarty()->assign('errorText', $errorText);
Template::getSmarty()->assign('request', $request);
Template::getSmarty()->display('login.tpl');
