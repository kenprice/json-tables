<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Notification;

/**
 * Class Table
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
        if (array_key_exists("name", $dictTable)) {
            $this->name = $dictTable["name"];
        }
        if (array_key_exists("fields", $dictTable)) {
            $this->populateFields($dictTable["fields"]);
        }
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
     */
    private function populateFields(array $dictFields)
    {
        $this->fields = [];
        foreach ($dictFields as $dictField) {
            $field = new Field($dictField);
            array_push($this->fields, $field);
        }
    }

    public function check()
    {
        if ($this->validation()->hasErrors()) {
            throw new Exceptions\InvalidSchemaException(
                $this->validation()->errorMessages('Invalid Table')
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
        if ($this->fields === null) {
            $note->addError('"fields" is required.');
        }
        return $note;
    }
}
