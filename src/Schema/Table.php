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
    /**
     * @var string Table name
     */
    private $_name;
    /**
     * @var Field[] Fields of the table
     */
    private $_fields;
    /**
     * @var string Field name of the primary key
     */
    private $_primaryKey;
    /**
     * @var ForeignKey[] Foreign keys of the table
     */
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
            $this->_primaryKey = $dictTable["primaryKey"];
        }
        if (array_key_exists("foreignKeys", $dictTable)) {
            $this->populateForeignKeys($dictTable["foreignKeys"]);
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

    /**
     * Populates foreign keys with Foreign Key objects from keys in parsed JSON schema
     * @param array $dictForeignKeys
     */
    private function populateForeignKeys(array $dictForeignKeys)
    {
        $this->_foreignKeys = [];
        foreach ($dictForeignKeys as $dictForeignKey) {
            $foreignKey = new ForeignKey($dictForeignKey);
            array_push($this->_foreignKeys, $foreignKey);
        }
    }

    /**
     * Validation for foreign keys. Checks if foreign keys are existing fields.
     * @param Notification $note
     */
    private function validateForeignKeys(Notification $note)
    {
        foreach ($this->_foreignKeys as $foreignKey) {
            $foreignKey->validation($note);
            $foreignKeyName = $foreignKey->getField();
            $fieldExists = false;
            foreach ($this->_fields as $field) {
                if ($field->getName() == $foreignKeyName) {
                    $fieldExists = true;
                }
                if ($fieldExists) {
                    break;
                }
            }
            if (!$fieldExists) {
                $note->addError("Foreign key \"{$foreignKeyName}\" must have a field.");
            }
        }
    }

    /**
     * Validation for primary key. Checks if primary key references a unique field.
     * @param Notification $note
     */
    private function validatePrimaryKey(Notification $note)
    {
        if ($this->_primaryKey === null || empty($this->_fields)) {
            return;
        }

        // If primary key is not in a list of field names, then it is invalid.
        $fieldNames =
            array_map(
                function(Field $f) {
                    return $f->getName();
                },
                $this->_fields
            );
        $primaryKeyNotValidField =
            !in_array(
                $this->_primaryKey,
                $fieldNames
            );
        if ($primaryKeyNotValidField) {
            $note->addError('"primaryKey" must be a name of an existing field.');
            return;
        }

        // If primary key references an existing field, but the field is not unique
        // nor a foreign key, then it is invalid.
        $fieldsUniqueness =
            array_map(
                function (Field $f) {
                    return $f->getConstraints() && $f->getConstraints()->getUnique();
                },
                $this->_fields
            );
        $primaryKeyUnique =
            array_combine(
                $fieldNames,
                $fieldsUniqueness
            )[$this->_primaryKey];
        $foreignKeys =
            array_map(
                function (ForeignKey $f) {
                    return $f->getField();
                },
                $this->_foreignKeys ?? []
            );
        $primaryKeyForeignKey = in_array($this->_primaryKey, $foreignKeys);

        if (!$primaryKeyUnique && !$primaryKeyForeignKey) {
            $note->addError('"primaryKey" must be a unique field.');
            return;
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

    public function validation(Notification $note = null)
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
        $this->validatePrimaryKey($note);
        if (empty($this->_foreignKeys) && $this->_foreignKeys !== null) {
            $note->addError('"foreignKeys" cannot be empty.');
        }
        if (!empty($this->_foreignKeys)) {
            $this->validateForeignKeys($note);
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
     * @return Field[]
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * @return mixed|string
     */
    public function getPrimaryKey()
    {
        return $this->_primaryKey;
    }

    /**
     * @return ForeignKey[]
     */
    public function getForeignKeys()
    {
        return $this->_foreignKeys;
    }
}
