<?php

namespace JsonTables;

/**
 * Indicates that an invalid JSON string was attempting to be used.
 */
class InvalidJsonException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}