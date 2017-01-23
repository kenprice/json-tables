<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Helpers\StringHelper;

/**
 * Class Field
 */
class Field
{
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
        if (!array_key_exists("name", $dictField)) {
            throw new Exceptions\InvalidSchemaException('"name" is required.');
        }
        if (!array_key_exists("type", $dictField)) {
            throw new Exceptions\InvalidSchemaException('"type" is required.');
        }
        $this->name = $dictField["name"];
        $this->type = $dictField["type"];
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
        $this->validate();
    }

    private function validate()
    {
        $this->validateName();
        $this->validateType();
    }

    private function validateName()
    {
        if (!StringHelper::stringIsAlphaNumDashUnderscore($this->name)) {
            throw new Exceptions\InvalidSchemaException('"name" must be alphanumeric with dash or underscore.');
        }
    }

    private function validateType()
    {
        if (!FieldTypeEnum::has($this->type)) {
            throw new Exceptions\InvalidSchemaException('"type" is invalid.');
        }
    }
}