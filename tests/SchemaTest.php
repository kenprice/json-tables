<?php

use JsonTables\Schema\Schema;
use PHPUnit\Framework\TestCase;

class SchemaTest extends PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionOnInvalidJson()
    {
        $this->expectException(JsonTables\Exceptions\InvalidJsonException::class);
        $jsonSchema = '{ "badJson": }';
        new Schema($jsonSchema);
    }

    public function testShouldPopulateTablesGivenValidJsonTableSchemaWithTwoTables()
    {
        $jsonSchema = file_get_contents("tests/test-schemas/UsersAndPosts.json");
        $schema = new \JsonTables\Schema\Schema($jsonSchema);
        $tables = $schema->getTables();
        $this->assertCount(2, $tables);
    }
}
