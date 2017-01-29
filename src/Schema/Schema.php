<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\IValidate;
use JsonTables\Notification;

/**
 * Class Schema
 * @package JsonTables
 */
class Schema implements IValidate
{
    /**
     * @var Table[] All tables of the schema.
     */
    private $_tables;

    /**
     * Schema constructor. Builds schema from a JSON Schema
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

    public function validation(Notification $note = null)
    {
        $note = new Notification();
        if (empty($this->_tables)) {
            $note->addError('"tables" is required.');
            return $note;
        }
        foreach ($this->_tables as $table) {
            $table->validation($note);
        }
        $this->validateTables($note);
        $this->validateForeignKeys($note);
        return $note;
    }

    /**
     * Validation for foreign keys. Checks if each foreign key references valid primary key.
     * @param Notification $note
     */
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
                        "{$foreignKey->getReferencedResource()} is not valid."
                    );
                }
            }
        }
    }

    /**
     * Validation for foreign key. Checks if foreign key references valid primary key.
     * @param ForeignKey $foreignKey
     * @return bool
     */
    private function isForeignKeyValid(ForeignKey $foreignKey)
    {
        foreach ($this->_tables as $table) {
            if (!$table->getPrimaryKey()) {
                continue;
            }
            if ($table->getPrimaryKey() == $foreignKey->getReferencedField()) {
                return true;
            }
        }
        return false;
    }


    /**
     * Validation for tables. Checks if table names are unique.
     * @param Notification $note
     */
    private function validateTables(Notification $note)
    {
        $tableNames = [];
        foreach ($this->_tables as $table) {
            $tableName = $table->getName();
            if (in_array($tableName, $tableNames)) {
                $note->addError("{$tableName} is not a unique table name.");
            }
            array_push($tableNames, $tableName);
        }
    }

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return $this->_tables;
    }
}

