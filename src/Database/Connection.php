<?php

namespace JsonTables\Database;

use JsonTables\Config;
use \Doctrine\DBAL\DriverManager;

class Connection
{
    private static $_instance;

    public static function get()
    {
        if (!Connection::$_instance) {
            $dbConfig = Config::get('dbconfig');
            Connection::$_instance = DriverManager::getConnection($dbConfig);
        }
        return Connection::$_instance;
    }
}
