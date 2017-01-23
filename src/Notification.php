<?php

namespace JsonTables;

/**
 * Class Notification - Stores error notifications (e.g. validation errors, anywhere where exceptions may
 * not be appropriate).
 */
class Notification
{
    private $_errors;

    /**
     * Notification constructor.
     * @param $errors
     */
    public function __construct(array $errors = null)
    {
        if (!$errors) {
            $this->_errors = [];
            return;
        }
        $this->_errors = $errors;
    }

    public function addError(string $message)
    {
        array_push($this->_errors, $message);
    }

    public function errorMessages($strHead = null)
    {
        if ($strHead) {
            return $strHead . '\n' . join('\n', $this->_errors);
        }
        return join('\n', $this->_errors);
    }

    public function hasErrors()
    {
        return count($this->_errors) > 0;
    }
}