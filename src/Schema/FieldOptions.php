<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Helpers\StringHelper;
use JsonTables\IValidate;
use JsonTables\Notification;

class FieldOptions implements IValidate
{
    /**
     * @var array Associative array for the FieldOptions, generated from JSON schema
     */
    private $_dictOptions;
    /**
     * @var bool|null Autoincrement option for integer fields.
     */
    private $_autoincrement;
    /**
     * @var mixed Default value of field.
     */
    private $_default;

    /**
     * FieldOption constructor.
     */
    public function __construct($dictOptions)
    {
        $this->_dictOptions = $dictOptions;
        if (array_key_exists(FieldOptionTypeEnum::AUTOINCREMENT, $dictOptions)) {
            $this->_autoincrement = StringHelper::parseBool($dictOptions[FieldOptionTypeEnum::AUTOINCREMENT]);
        }
        if (array_key_exists(FieldOptionTypeEnum::DEFAULT, $dictOptions)) {
            $this->_default = $dictOptions[FieldOptionTypeEnum::DEFAULT];
        }
    }

    public function check()
    {
        if ($this->validation()->hasErrors()) {
            throw new Exceptions\InvalidSchemaException(
                $this->validation()->errorMessages('Invalid Field Options')
            );
        }
    }

    public function validation(Notification $note = null)
    {
        $note = $note ?? new Notification();
        if (array_key_exists(FieldOptionTypeEnum::AUTOINCREMENT, $this->_dictOptions)
            && $this->_autoincrement === null) {
            $note->addError('"autoincrement" must be a boolean.');
        }
    }

    /**
     * @return bool
     */
    public function getAutoincrement()
    {
        return $this->_autoincrement === true;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->_default;
    }
}
