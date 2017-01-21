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
        $this->_tables = [];

        if (!$dictSchema) {
            throw new \Exception("Invalid JSON.");
        }

        foreach ($dictSchema["tables"] as $dictTable) {
            $table = new Table($dictTable);
            array_push($this->_tables, $table);
        }
    }

    /**
     * @return array Array of Table objects
     */
    public function getTables()
    {
        return $this->_tables;
    }
}

