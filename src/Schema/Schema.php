<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Notification;

/**
 * Class Schema
 * @package JsonTables
 */
class Schema
{
    private $_tables;

    /**
     * Schema constructor.
     * @param string $jsonSchema
     * @throws Exceptions\InvalidJsonException
     */
    public function __construct(string $jsonSchema)
    {
        $dictSchema = json_decode($jsonSchema, true);

        if (!$dictSchema) {
            throw new Exceptions\InvalidJsonException("Invalid JSON.");
        }

        $this->populateTables($dictSchema);
    }

    /**
     * @return array Array of Table objects
     */
    public function getTables()
    {
        return $this->_tables;
    }

    /**
     * Populates tables with Table objects from parsed JSON schema
     * @param array $dictSchema
     * @throws Exceptions\InvalidSchemaException
     */
    private function populateTables(array $dictSchema)
    {
        $this->_tables = [];
        if (!array_key_exists("tables", $dictSchema)) {
            throw new Exceptions\InvalidSchemaException('"tables" is required.');
        }
        foreach ($dictSchema["tables"] as $dictTable) {
            $table = new Table($dictTable);
            array_push($this->_tables, $table);
        }
    }

    public function check()
    {
        if ($this->validation()->hasErrors()) {
            throw new Exceptions\InvalidSchemaException(
                $this->validation()->errorMessages('Invalid Schema')
            );
        }
    }

    public function validation()
    {
        $note = new Notification();
        if (empty($this->_tables)) {
            $note->addError('"tables" is required.');
            return $note;
        }
        foreach ($this->_tables as $table) {
            $table->validation($note);
        }
        $this->validateForeignKeys($note);
        return $note;
    }

    private function validateForeignKeys(Notification $note)
    {
        foreach ($this->_tables as $table) {
            if (!$table->getForeignKeys()) {
                continue;
            }
            foreach ($table->getForeignKeys() as $foreignKey) {
                if (!$this->isForeignKeyValid($foreignKey)) {
                    $note->addError(
                        "Foreign key {$foreignKey->getField()} referencing {$foreignKey->getReferencedField()} from " .
                        "{$foreignKey->getReferencedField()} is not valid."
                    );
                }
            }
        }
    }

    private function isForeignKeyValid(ForeignKey $foreignKey)
    {
        foreach ($this->_tables as $table) {
            if (!$table->getForeignKeys()) {
                continue;
            }
            if ($table->getPrimaryKey() == $foreignKey->getField()) {
                return true;
            }
        }
        return false;
    }
}

