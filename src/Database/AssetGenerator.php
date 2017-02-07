<?php

namespace JsonTables\Database;

use JsonTables\Schema\Schema;
use JsonTables\Schema\Table;
use JsonTables\Schema\Field;
use \Doctrine\DBAL;

/**
 * Class AssetGenerator
 * @package JsonTables\Database
 */
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
     * @var \Doctrine\DBAL\Driver\Connection
     */
    private $_connection;

    /**
     * AssetGenerator constructor.
     * @param Schema $schema JsonTables schema
     * @param \Doctrine\DBAL\Driver\Connection $conn
     */
    public function __construct(Schema $schema, DBAL\Driver\Connection $conn)
    {
        $this->_jsonTablesSchema = $schema;
        $this->_connection = $conn;
    }

    /**
     * Generates tables from JSON table schema.
     */
    public function generate()
    {
        $dictTables = array();
        $this->_schema = new DBAL\Schema\Schema();
        $this->_jsonTablesSchema->check();
        foreach ($this->_jsonTablesSchema->getTables() as $table) {
            $dictTables[$table->getName()] = $this->addTable($table);
        }
        $this->addForeignKeyConstraints($dictTables);
        $queries = $this->_schema->toSql($this->_connection->getDatabasePlatform());
        foreach ($queries as $query) {
            $this->_connection->executeQuery($query);
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
            $this->addColumnToTable($table, $field);
        }
        $primaryKey = $jsonTable->getPrimaryKey();
        if ($primaryKey) {
            $table->setPrimaryKey(array($primaryKey));
        }
        return $table;
    }

    /**
     * Adds a field to the table, generated from Schema\Field
     * @param \Doctrine\DBAL\Schema\Table $table
     * @param Field $field
     */
    private function addColumnToTable(DBAL\Schema\Table $table, Field $field)
    {
        $options = array();
        if ($field->getConstraints()) {
            $options = ConstraintsTranslator::translate(
                $field->getConstraints()
            );
        }
        $description = $field->getDescription();
        if ($description) {
            $options['description'] = $description;
        }
        $table->addColumn(
            $field->getName(),
            $field->getType(),
            $options
        );
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
