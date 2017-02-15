<?php

namespace JsonTables;

use Doctrine\DBAL\DriverManager;
use JsonTables\Database\AssetGenerator;
use JsonTables\Schema\Schema;

/**
 * Class JsonTables
 * @package JsonTables
 */
class JsonTables
{
    /**
     * Generates tables for the database specified in $dbConfig. Table schemas are
     * generated from the JSON Schema specified in $path.
     * @param string $jsonSchema JSON Schema representation
     * @param array $dbConfig For Doctrine DBAL connection
     */
    public static function generateAssetsFromJsonTable($jsonSchema, $dbConfig)
    {
        $schema = new Schema($jsonSchema);
        JsonTables::generateAssetsFromSchema($schema, $dbConfig);
    }

    /**
     * Generates tables for the database specified in $dbConfig. Table schemas are
     * generated from a JsonSchema object
     * @param Schema $schema json-tables schema
     * @param array $dbConfig For Doctrine DBAL connection
     */
    public static function generateAssetsFromSchema(Schema $schema, $dbConfig)
    {
        $conn = DriverManager::getConnection($dbConfig);
        $schema->check();
        $assetGenerator = new AssetGenerator($schema, $conn);
        $assetGenerator->generate();
    }
}
