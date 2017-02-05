<?php

namespace JsonTables\Database;

use JsonTables\Schema\Schema;
use JsonTables\Schema\Table;

class AssetGenerator
{
    /**
     * @var Schema Parsed JSON Table Schema
     */
    private $_jsonTablesSchema;
    /**
     * @var \Doctrine\DBAL\Schema\Schema
     */
    private $_schema;

    /**
     * AssetGenerator constructor.
     * @param $schema Schema JsonTables schema
     */
    public function __construct(Schema $schema)
    {
        $this->_jsonTablesSchema = $schema;
    }

    /**
     * Generates tables from JSON table schema.
     */
    public function generate()
    {
        $dictTables = array();
        $conn = Connection::get();
        $this->_schema = new \Doctrine\DBAL\Schema\Schema();
        $this->_jsonTablesSchema->check();
        foreach ($this->_jsonTablesSchema->getTables() as $table) {
            $dictTables[$table->getName()] = $this->addTable($table);
        }
        $this->addForeignKeyConstraints($dictTables);
        $queries = $this->_schema->toSql($conn->getDatabasePlatform());
        foreach ($queries as $query) {
            $conn->executeQuery($query);
        }
    }

    /**
     * Adds a new table to the Doctrine schema representation. The table is generated
     * from parsed JSON Table schema. Does not add foreign keys, but does add primary
     * keys and constraints.
     * @param Table $jsonTable
     * @return \Doctrine\DBAL\Schema\Table Generated table
     */
    private function addTable(Table $jsonTable)
    {
        $table = $this->_schema->createTable($jsonTable->getName());
        foreach ($jsonTable->getFields() as $field) {
            $constraints = array();
            if ($field->getConstraints()) {
                $constraints = ConstraintsTranslator::translate(
                    $field->getConstraints()
                );
            }
            $table->addColumn(
                $field->getName(),
                $field->getType(),
                $constraints
            );
        }
        $primaryKey = $jsonTable->getPrimaryKey();
        if ($primaryKey) {
            $table->setPrimaryKey(array($primaryKey));
        }
        return $table;
    }

    /**
     * Adds foreign key constraints to tables.
     * @param array $dictTable Associative array of table name to DBAL Table object
     */
    private function addForeignKeyConstraints(array $dictTable)
    {
        foreach ($this->_jsonTablesSchema->getTables() as $table) {
            $foreignKeys = $table->getForeignKeys();
            if (!$foreignKeys) {
                continue;
            }
            foreach ($foreignKeys as $foreignKey) {
                $dictTable[$table->getName()]->addForeignKeyConstraint(
                    $dictTable[$foreignKey->getReferencedResource()],
                    array($foreignKey->getField()),
                    array($foreignKey->getReferencedField())
                );
            }
        }
    }
}
