<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Notification;
use JsonTables\Helpers\StringHelper;

/**
 * Class Table
 */
class Table
{
    private $_name;
    private $_fields;
    private $_primaryKeys;
    private $_foreignKeys;

    /**
     * Table constructor.
     * @param array $dictTable Array containing name, fields, primaryKeys,
     *                         and foreignKeys
     */
    public function __construct(array $dictTable)
    {
        if (array_key_exists("name", $dictTable)) {
            $this->_name = $dictTable["name"];
        }
        if (array_key_exists("fields", $dictTable)) {
            $this->populateFields($dictTable["fields"]);
        }
        if (array_key_exists("primaryKey", $dictTable)) {
            $this->_primaryKeys = $dictTable["primaryKey"];
        }
        if (array_key_exists("foreignKeys", $dictTable)) {
            $this->_foreignKeys = $dictTable["foreignKeys"];
        }
    }

    /**
     * Populates fields with Field objects from table fields in parsed JSON schema
     * @param array $dictFields
     */
    private function populateFields(array $dictFields)
    {
        $this->_fields = [];
        foreach ($dictFields as $dictField) {
            $field = new Field($dictField);
            array_push($this->_fields, $field);
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

    public function validation($note = null)
    {
        $note = $note ?? new Notification();
        if ($this->_name === null) {
            $note->addError('"name" is required.');
        }
        if ($this->_name !== null && !StringHelper::stringIsAlphaNumDashUnderscore($this->_name)) {
            $note->addError('"name" must contain only alphanumeric characters, dash, or underscore.');
        }
        if (empty($this->_fields)) {
            $note->addError('"fields" is required.');
        } else {
            foreach ($this->_fields as $field) {
                $field->validation($note);
            }
        }
        return $note;
    }
}
