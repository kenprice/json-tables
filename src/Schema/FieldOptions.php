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
     * @var string Field type
     */
    private $_fieldType;

    /**
     * FieldOption constructor.
     * @param array $dictOptions Field options as associative array
     * @param string Field type (enumerated in FieldOptionTypeEnum)
     */
    public function __construct($dictOptions, $fieldType)
    {
        $this->_dictOptions = $dictOptions;
        if (array_key_exists(FieldOptionTypeEnum::AUTOINCREMENT, $dictOptions)) {
            $this->_autoincrement = StringHelper::parseBool($dictOptions[FieldOptionTypeEnum::AUTOINCREMENT]);
        }
        if (array_key_exists(FieldOptionTypeEnum::DEFAULT, $dictOptions)) {
            $this->_default = $dictOptions[FieldOptionTypeEnum::DEFAULT];
        }
        $this->_fieldType = $fieldType;
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

        // Default values only supported for integer, number, string.
        $acceptableDefaultTypes = [FieldTypeEnum::INTEGER, FieldTypeEnum::STRING];
        $fieldTypeDefaultSupported = in_array($this->_fieldType, $acceptableDefaultTypes);
        if ($this->_default && !$fieldTypeDefaultSupported) {
            $note->addError('Unsupported type for "default"');
        }

        if ($this->_default && $this->_fieldType == FieldTypeEnum::INTEGER) {
            if (StringHelper::parseInt($this->_default) === null) {
                $note->addError('"default" is not a valid integer');
            }
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
