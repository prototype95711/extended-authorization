<?php

namespace AuthorizationSystem;

use Smarty\Smarty;

class Template 
{
    private static $templator;

    public static function getSmarty()
    {
        return self::$templator;
    }

    public static function init()
    {
        if (empty(self::getSmarty())) {
            self::$templator = new Smarty();

            self::$templator->setTemplateDir(SMARTY_TEMPLATES_FOLDER);
            self::$templator->setConfigDir(SMARTY_CONFIGS_FOLDER);
            self::$templator->setCompileDir(SMARTY_TEMPLATES_C_FOLDER);
            self::$templator->setCacheDir(SMARTY_CACHE_FOLDER);
        }
    }
}
