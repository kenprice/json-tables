<?php

namespace JsonTables;

use Doctrine\DBAL\DriverManager;
use JsonTables\Database\AssetGenerator;

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
        $conn = DriverManager::getConnection($dbConfig);
        $schema = new Schema\Schema($jsonSchema);
        $schema->check();
        $assetGenerator = new AssetGenerator($schema, $conn);
        $assetGenerator->generate();
    }
}
