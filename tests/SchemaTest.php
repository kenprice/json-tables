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

    public function testShouldErrorGivenJsonTableSchemaWithMissingTables()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $jsonSchema = file_get_contents("tests/test-schemas/EmptyTables.json");
        $schema = new \JsonTables\Schema\Schema($jsonSchema);
        $schema->check();
    }

    public function testShouldErrorGivenJsonTableSchemaWithInvalidTable()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $jsonSchema = file_get_contents("tests/test-schemas/UsersAndPostsInvalidTable.json");
        $schema = new \JsonTables\Schema\Schema($jsonSchema);
        $schema->check();
    }

    public function testShouldErrorGivenJsonTableSchemaWithInvalidField()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $jsonSchema = file_get_contents("tests/test-schemas/UsersAndPostsInvalidField.json");
        $schema = new \JsonTables\Schema\Schema($jsonSchema);
        $schema->check();
    }

    public function testShouldErrorGivenJsonTableSchemaWithInvalidConstraints()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $jsonSchema = file_get_contents("tests/test-schemas/UsersAndPostsInvalidConstraints.json");
        $schema = new \JsonTables\Schema\Schema($jsonSchema);
        $schema->check();
    }

    public function testShouldErrorGivenJsonTableSchemaWithInvalidPrimaryKey()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $jsonSchema = file_get_contents("tests/test-schemas/UsersAndPostsInvalidPrimaryKey.json");
        $schema = new \JsonTables\Schema\Schema($jsonSchema);
        $schema->check();
    }

    public function testShouldErrorGivenJsonTableSchemaWithInvalidForeignKey()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $jsonSchema = file_get_contents("tests/test-schemas/UsersAndPostsInvalidForeignKey.json");
        $schema = new \JsonTables\Schema\Schema($jsonSchema);
        $schema->check();
    }
}
