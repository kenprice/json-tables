<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Helpers\StringHelper;
use JsonTables\IValidate;
use JsonTables\Notification;

/**
 * Class Field
 */
class Field implements IValidate
{
    /**
     * @var array Associative array for the field, generated from JSON schema
     */
    private $_dictField;
    /**
     * @var string Name of the field
     */
    private $_name;
    /**
     * @var string Human-readable designation for the field
     */
    private $_title;
    /**
     * @var FieldTypeEnum Type of the field
     */
    private $_type;
    /**
     * @var mixed Format of the field
     */
    private $_format;
    /**
     * @var string Description of the field
     */
    private $_description;
    /**
     * @var Constraints Constraints on the field
     */
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

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return FieldTypeEnum|mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->_format;
    }

    /**
     * @return mixed|string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return Constraints
     */
    public function getConstraints()
    {
        return $this->_constraints;
    }
}