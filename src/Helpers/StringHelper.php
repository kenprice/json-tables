<?php

namespace JsonTables\Helpers;

/**
 * Various helper functions for regex testing and possibly other things
 */
class StringHelper
{
    public static function stringIsAlphaNumDashUnderscore(string $str)
    {
        return preg_match('/^[\w\-]+$/', $str) === 1;
    }
}
