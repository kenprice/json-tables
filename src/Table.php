<?php

/**
 * @file
 * Definition of Table
 */

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
        $this->fields = $dictTable["fields"];
        $this->primaryKey = $dictTable["primaryKey"];
        $this->foreignKeys = $dictTable["foreignKeys"];
    }
}
