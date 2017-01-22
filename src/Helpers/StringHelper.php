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

    /**
     * Parses input to non-negative integer. Null if invalid.
     * @param string $str
     * @return mixed
     */
    public static function parseIntNonNegative(string $str)
    {
        return filter_var(
            $str,
            FILTER_VALIDATE_INT,
            array(
                "options" => array("min_range" => 0),
                "flags" => FILTER_NULL_ON_FAILURE)
        );
    }

    /**
     * Parses input to bool. Null if invalid.
     * Note: Blank string will return false.
     * @param string $str
     * @return mixed
     */
    public static function parseBool(string $str)
    {
        return filter_var(
            $str,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
    }
}
