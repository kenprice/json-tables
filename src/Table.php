<?php

namespace JsonTables;

/**
 * Class Table
 * @package JsonTables
 */
class Table
{
    public $name;
    public $fields;
    public $primaryKey;
    public $foreignKeys;

    /**
     * Table constructor.
     * @param array $dictTable Array containing name, fields, primaryKeys,
     *                         and foreignKeys
     * @throws Exceptions\InvalidSchemaException
     */
    public function __construct(array $dictTable)
    {
        if (!array_key_exists("name", $dictTable)) {
            throw new Exceptions\InvalidSchemaException('"name" is required.');
        }
        if (!array_key_exists("fields", $dictTable)) {
            throw new Exceptions\InvalidSchemaException('"fields" is required.');
        }
        $this->name = $dictTable["name"];
        $this->populateFields($dictTable["fields"]);
        if (array_key_exists("primaryKey", $dictTable)) {
            $this->primaryKey = $dictTable["primaryKey"];
        }
        if (array_key_exists("foreignKeys", $dictTable)) {
            $this->foreignKeys = $dictTable["foreignKeys"];
        }
    }


    /**
     * Populates fields with Field objects from table fields in parsed JSON schema
     * @param array $dictFields
     * @throws Exceptions\InvalidSchemaException
     */
    private function populateFields(array $dictFields)
    {
        if (!$dictFields) {
            throw new Exceptions\InvalidSchemaException('"fields" cannot be empty.');
        }
        $this->fields = [];
        foreach ($dictFields as $dictField) {
            $field = new Field($dictField);
            array_push($this->fields, $field);
        }
    }
}
