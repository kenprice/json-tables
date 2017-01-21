<?php

namespace JsonTables;

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
     * @throws \Exception
     */
    public function __construct(string $jsonSchema)
    {
        $dictSchema = json_decode($jsonSchema, true);

        if (!$dictSchema) {
            throw new \Exception("Invalid JSON.");
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
     */
    private function populateTables(array $dictSchema)
    {
        $this->_tables = [];
        foreach ($dictSchema["tables"] as $dictTable) {
            $table = new Table($dictTable);
            array_push($this->_tables, $table);
        }
    }
}

