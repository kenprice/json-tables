<?php

use JsonTables\Schema\Table;
use JsonTables\Exceptions\InvalidSchemaException;
use PHPUnit\Framework\TestCase;

class TableTest extends PHPUnit_Framework_TestCase
{
    public function testDoesNotThrowExceptionOnValidTable()
    {
        $jsonTable = file_get_contents("tests/test-jsontables/Posts.json");
        $dictTable = json_decode($jsonTable, true);
        $table = new Table($dictTable);
        $table->check();
    }

    public function testThrowsExceptionOnEmptyArray()
    {
        $this->expectException(InvalidSchemaException::class);
        $dictTable = array();
        $table = new Table($dictTable);
        $table->check();
    }

    public function testThrowsExceptionWhenForeignKeyHasNoValidField()
    {
        $this->expectException(InvalidSchemaException::class);
        $jsonTable = file_get_contents("tests/test-jsontables/PostsForeignKeyWithNoValidField.json");
        $dictTable = json_decode($jsonTable, true);
        $table = new Table($dictTable);
        $table->check();
    }

    public function testThrowsExceptionWhenPrimaryKeyHasNoValidField()
    {
        $this->expectException(InvalidSchemaException::class);
        $jsonTable = file_get_contents("tests/test-jsontables/PostsPrimaryKeyWithNoValidField.json");
        $dictTable = json_decode($jsonTable, true);
        $table = new Table($dictTable);
        $table->check();
    }

    public function testThrowsExceptionWhenPrimaryKeyIsNotUniqueField()
    {
        $this->expectException(InvalidSchemaException::class);
        $jsonTable = file_get_contents("tests/test-jsontables/PostsPrimaryKeyIsNotUniqueField.json");
        $dictTable = json_decode($jsonTable, true);
        $table = new Table($dictTable);
        $table->check();
    }
}
