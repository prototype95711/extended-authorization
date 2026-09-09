<?php

function add_notify($notify, $page)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION[NOTIFY_SESSION_ID])) {
        $_SESSION[NOTIFY_SESSION_ID] = array();
    }

    if (!isset($_SESSION[NOTIFY_SESSION_ID][$page])) {
        $_SESSION[NOTIFY_SESSION_ID][$page] = array();
    }

    $_SESSION[NOTIFY_SESSION_ID][$page][] = $notify;
}

function get_notifions($page)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION[NOTIFY_SESSION_ID][$page])) {

        $notifions = $_SESSION[NOTIFY_SESSION_ID][$page];
        unset($_SESSION[NOTIFY_SESSION_ID][$page]);

        return $notifions;
    }

    return false;
}
