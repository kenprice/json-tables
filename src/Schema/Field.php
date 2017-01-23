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
    public $name;
    public $title;
    public $type;
    public $format;
    public $description;
    public $constraints;

    /**
     * Field constructor.
     * @param array $dictField Array containing information about table fields
     * @throws Exceptions\InvalidSchemaException
     */
    public function __construct(array $dictField)
    {
        $this->_dictField = $dictField;
        if (array_key_exists("name", $dictField)) {
            $this->name = $dictField["name"];
        }
        if (array_key_exists("type", $dictField)) {
            $this->type = $dictField["type"];
        }
        if (array_key_exists("title", $dictField)) {
            $this->title = $dictField["title"];
        }
        if (array_key_exists("format", $dictField)) {
            $this->format = $dictField["format"];
        }
        if (array_key_exists("descriptions", $dictField)) {
            $this->description = $dictField["description"];
        }
        if (array_key_exists("constraints", $dictField)) {
            $this->constraints = $dictField["constraints"];
        }
    }

    public function check()
    {
        if ($this->validation()->hasErrors()) {
            throw new Exceptions\InvalidSchemaException(
                $this->validation()->errorMessages('Invalid Constraints')
            );
        }
    }

    public function validation()
    {
        $note = new Notification();
        if ($this->name === null) {
            $note->addError('"name" is required.');
        }
        if ($this->name !== null && !StringHelper::stringIsAlphaNumDashUnderscore($this->name)) {
            $note->addError('"name" must contain only alphanumeric characters, dash, or underscore.');
        }
        if ($this->type === null) {
            $note->addError('"type" is required.');
        }
        if ($this->type !== null && !FieldTypeEnum::has($this->type)) {
            $note->addError('"type" is invalid.');
        }
        return $note;
    }
}