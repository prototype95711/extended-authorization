<?php

use AuthorizationSystem\Session;
use AuthorizationSystem\Database;

function is_authorized()
{
    try {

        $Session = new Session();
        $Session->read();

        return true;

    } catch (Exception $e) {
        
        return false;
    } 

    return false;
}

function get_current_user_id()
{
    try {

        $Session = new Session();
        $Session->read();
        $data = $Session->getData();

        return $data["user_id"];

    } catch (Exception $e) {
        
        return false;
    } 

    return false;
}

function get_current_user_type()
{
    try {

        $userId = get_current_user_id();
        $table = TABLE_PREFIX . TABLE_USERS;
        $userType = Database::getDb()->getOne("SELECT user_type FROM ?n WHERE id = ?i", $table, $userId);

        return (int) $userType;

    } catch (Exception $e) {
        
        return false;
    } 

    return false;
}
