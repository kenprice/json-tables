<?php

use JsonTables\Schema\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionOnEmptyArray()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictField = array();
        $field = new Field($dictField);
        $field->check();
    }
}
