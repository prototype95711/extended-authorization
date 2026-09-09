<?php

use AuthorizationSystem\UserRequest;
use AuthorizationSystem\Database;
use AuthorizationSystem\Template;

if (is_authorized() === false) {
    
    header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/login/");
    exit();
}

$editError = '';
$passwordError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $request = $_REQUEST;

    if ($request["mode"] == "update_user_data") {

        try {
            $userId = get_current_user_id();
            $User = new UserRequest($request, "update");
            $operationResult = $User->update($userId);

            add_notify("Имя и фамилия успешно изменены.", "profile.edit");
    
        } catch (Exception $e) {
    
            $editError = $e->getMessage() . "\n";
        } 
    } 
    
    if ($request["mode"] == "change_password") {

        try {
            $userId = get_current_user_id();
            $User = new UserRequest($request, "update_password");
            $operationResult = $User->updatePassword($userId);
            
            add_notify("Пароль успешно изменен.", "profile.password");

        } catch (Exception $e) {
    
            $passwordError = $e->getMessage() . "\n";
        } 
    }
}

$currUserId = get_current_user_id();

if ($currUserId !== false) {
    $table = TABLE_PREFIX . TABLE_USERS;
    $userData = Database::getDb()->getRow("SELECT user_first_name, user_second_name FROM ?n WHERE id = ?i", $table, $currUserId); 
}

$notifionsEdit = get_notifions("profile.edit");
$notifionsPassword = get_notifions("profile.password");

Template::getSmarty()->assign('userData', $userData);
Template::getSmarty()->assign('errorEdit', $editError);
Template::getSmarty()->assign('errorPassw', $passwordError);
Template::getSmarty()->assign('notifionsEdit', $notifionsEdit);
Template::getSmarty()->assign('notifionsPassw', $notifionsPassword);
Template::getSmarty()->display('profile.tpl');
