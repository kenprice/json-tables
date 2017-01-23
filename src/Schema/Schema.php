<?php

namespace JsonTables\Schema;
use JsonTables\Exceptions;

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
}

