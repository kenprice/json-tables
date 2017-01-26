<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Helpers\StringHelper;
use JsonTables\Notification;

/**
 * Class Field
 */
class Field
{
    private $_dictField;
    private $_name;
    private $_title;
    private $_type;
    private $_format;
    private $_description;
    private $_constraints;

    /**
     * Field constructor.
     * @param array $dictField Array containing information about table fields
     * @throws Exceptions\InvalidSchemaException
     */
    public function __construct(array $dictField)
    {
        $this->_dictField = $dictField;
        if (array_key_exists("name", $dictField)) {
            $this->_name = $dictField["name"];
        }
        if (array_key_exists("type", $dictField)) {
            $this->_type = $dictField["type"];
        }
        if (array_key_exists("title", $dictField)) {
            $this->_title = $dictField["title"];
        }
        if (array_key_exists("format", $dictField)) {
            $this->_format = $dictField["format"];
        }
        if (array_key_exists("descriptions", $dictField)) {
            $this->_description = $dictField["description"];
        }
        if (array_key_exists("constraints", $dictField)) {
            $this->_constraints = new Constraints($dictField["constraints"]);
        }
    }

    public function check()
    {
        if ($this->validation()->hasErrors()) {
            throw new Exceptions\InvalidSchemaException(
                $this->validation()->errorMessages('Invalid Field')
            );
        }
    }

    public function validation(Notification $note = null)
    {
        $note = $note ?? new Notification();
        if ($this->_name === null) {
            $note->addError('"name" is required.');
        }
        if ($this->_name !== null && !StringHelper::stringIsAlphaNumDashUnderscore($this->_name)) {
            $note->addError('"name" must contain only alphanumeric characters, dash, or underscore.');
        }
        if ($this->_type === null) {
            $note->addError('"type" is required.');
        }
        if ($this->_type !== null && !FieldTypeEnum::has($this->_type)) {
            $note->addError('"type" is invalid.');
        }
        if ($this->_constraints) {
            $this->_constraints->validation($note);
        }
        return $note;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getFormat()
    {
        return $this->_format;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getConstraints()
    {
        return $this->_constraints;
    }
}