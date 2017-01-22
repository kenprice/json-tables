<?php

namespace JsonTables;

/**
 * Class Field
 * @package JsonTables
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
        $this->title = $dictField["title"];
        $this->type = $dictField["type"];
        $this->format = $dictField["format"];
        $this->description = $dictField["description"];
        $this->constraints = $dictField["constraints"];
    }
}