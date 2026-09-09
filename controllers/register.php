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

    if ($request["mode"] == "register") {

        try {

            $User = new UserRequest($request, "registration");
            $User->register();
            
            add_notify("Вы успешно зарегистрировались. Зайдите, используя свои email и пароль.", "login");

            header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/login/");
    
        } catch (Exception $e) {
    
            $errorText = $e->getMessage() . "\n";
        } 
    }  
}

Template::getSmarty()->assign('errorText', $errorText);
Template::getSmarty()->assign('request', $request);
Template::getSmarty()->display('register.tpl');
