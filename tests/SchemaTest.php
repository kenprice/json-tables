<?php

use JsonTables\Schema;
use PHPUnit\Framework\TestCase;

class SchemaTest extends PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionOnInvalidJson()
    {
        $this->expectException(JsonTables\Exceptions\InvalidJsonException::class);
        $jsonSchema = '{ "badJson": }';
        new Schema($jsonSchema);
    }
}
