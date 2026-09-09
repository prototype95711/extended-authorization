<?php

use AuthorizationSystem\UserTypes;
use AuthorizationSystem\UsersList;
use AuthorizationSystem\Template;

if (is_authorized() === false || get_current_user_type() !== UserTypes::ADMINISTRATOR) {
    
    header("Location: " . PROJECT_PROTOCOL . PROJECT_DOMAIN . "/login/");
    exit();
}

$request = $_REQUEST;
$error = '';

$page = isset($request["page"]) ? $request["page"] : 1;

try {
    $UsersList = new UsersList($page);
    $users = $UsersList->getItems();
    $pages = $UsersList->getNumPages();
    $currentPage = $UsersList->getCurrentPage();

} catch (Exception $e) {

    $error = $e->getMessage() . "\n";
} 

Template::getSmarty()->assign('error', $error);
Template::getSmarty()->assign('currentPage', $currentPage);
Template::getSmarty()->assign('pages', $pages);
Template::getSmarty()->assign('users', $users);
Template::getSmarty()->display('userlist.tpl');
