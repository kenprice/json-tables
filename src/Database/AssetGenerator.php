<?php

namespace JsonTables\Database;

use JsonTables\Schema\Schema;
use JsonTables\Schema\Table;

class AssetGenerator
{
    private $_jsonTablesSchema;
    private $_schema;

    /**
     * AssetGenerator constructor.
     * @param $schema Schema JsonTables schema
     */
    public function __construct(Schema $schema)
    {
        $this->_jsonTablesSchema = $schema;
    }

    public function generate()
    {
        $this->_schema = new \Doctrine\DBAL\Schema\Schema();
        $this->_jsonTablesSchema->check();
        foreach ($this->_jsonTablesSchema->getTables() as $table) {
            $this->addTable($table);
        }
        // TODO: Foreign key constraints.
        $queries = $this->_schema->toSql(Connection::get()->getDatabasePlatform());
        var_dump($queries);
    }

    private function addTable(Table $jsonTable)
    {
        $table = $this->_schema->createTable($jsonTable->getName());
        foreach ($jsonTable->getFields() as $field) {
            $constraints = array();
            if ($field->getConstraints()) {
                $constraints = ConstraintsTranslator::translate($field->getConstraints());
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
    }
}
