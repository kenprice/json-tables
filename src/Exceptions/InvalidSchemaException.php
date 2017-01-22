<?php

namespace JsonTables\Exceptions;

/**
 * Indicates that a schema is invalid
 */
class InvalidSchemaException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}