<?php

use JsonTables\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionOnEmptyArray() {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictFields = array();
        new Field($dictFields);
    }
}
