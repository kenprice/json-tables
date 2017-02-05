<?php

namespace JsonTables;

class Config
{
    private static $_instance;

    public static function get($key)
    {
        if (!Config::$_instance) {
            Config::$_instance = \Noodlehaus\Config::load('config.json');
        }
        return Config::$_instance->get($key);
    }
}
