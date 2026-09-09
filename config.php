<?php

/* For connection to database */
define('DB_HOST', 'localhost'); //host
define('DB_USER', 'root'); //login
define('DB_PASS', 'root'); //password
define('DB_NAME', 'authorization_system'); //database_name

/* Project config */
define('PROJECT_PROTOCOL', 'http://');
define('PROJECT_DOMAIN', 'eas.test');
define('TABLE_PREFIX', "authorizationsystem_");

/* For Router */
define('STANDARD_CONTROLLER', 'main');
define('CONTROLLERS_PATH', 'controllers');
define('CONTROLLER_404', '404.php');

/* User config */
define('EMAIL_MIN_LENGTH', 4);
define('EMAIL_MAX_LENGTH', 64);
define('PASSWORD_MIN_LENGTH', 4);

/* Session config */
define('USER_SESSION_ID', 'user_session');
define('NOTIFY_SESSION_ID', 'notify_session');
define('USER_SESSION_EXPIRETIME', 5500); //in seconds
define('TOKEN_SALT', 'Q45J55T');

/* Database tables */
define('TABLE_LOGIN_SESSIONS', 'login_sessions');
define('TABLE_USERS', 'users');

/* Users list config */
define('USERS_LIST_MAX_PER_PAGE', 10);

/* Smarty folders */
define('SERVER_ROOT', '/Users/glebperfiliev/Documents/eas/');
define('SMARTY_TEMPLATES_FOLDER', SERVER_ROOT . '/templates/template/');
define('SMARTY_TEMPLATES_C_FOLDER', SERVER_ROOT . '/templates/template_c/');
define('SMARTY_CONFIGS_FOLDER', SERVER_ROOT . '/templates/config/');
define('SMARTY_CACHE_FOLDER', SERVER_ROOT . '/templates/cache/');
