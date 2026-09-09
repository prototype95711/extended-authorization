<?php

namespace AuthorizationSystem;

class Database 
{
    private static $dbClass;

    public static function getDb()
    {
        return self::$dbClass;
    }

    public static function connect($config)
    {
        if (empty(self::getDb())) {
            self::$dbClass = new \SafeMySQL($config);
        }
    }
}
