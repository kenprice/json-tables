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
     */
    public function __construct(array $dictTable)
    {
        $this->name = $dictTable["name"];
        $this->fields = $dictTable["fields"];
        $this->primaryKey = $dictTable["primaryKey"];
        $this->foreignKeys = $dictTable["foreignKeys"];
    }


}