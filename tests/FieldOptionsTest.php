<?php

use JsonTables\Schema\FieldOptions;
use JsonTables\Schema\FieldTypeEnum;

class FieldOptionsTest extends PHPUnit_Framework_TestCase
{
    public function testAutoincrementTrueShouldSetAutoincrement()
    {
        $dictOptions = array(
            "autoincrement" => "true"
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::INTEGER);
        $this->assertTrue($fieldOption->getAutoincrement());
    }

    public function testAutoincrementFalseShouldUnsetAutoincrement()
    {
        $dictOptions = array(
            "autoincrement" => "false"
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::INTEGER);
        $this->assertFalse($fieldOption->getAutoincrement());
    }

    public function testAutoincrementGarbageInConstructorShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictOptions = array(
            "autoincrement" => "garbage"
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::INTEGER);
        $fieldOption->check();
    }

    public function testAutoincrementOptionForStringsShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictOptions = array(
            "autoincrement" => "true"
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::STRING);
        $fieldOption->check();
    }

    public function testDefaultOfIntegerOneForIntegerFieldShouldSetDefaultToOne()
    {
        $dictOptions = array(
            "default" => "1"
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::INTEGER);
        $this->assertEquals(1, $fieldOption->getDefault());
    }

    public function testDefaultOfIntegerNegOneForIntegerFieldShouldSetDefaultToNegOne()
    {
        $dictOptions = array(
            "default" => "-1"
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::INTEGER);
        $this->assertEquals(-1, $fieldOption->getDefault());
    }

    public function testDefaultOfSomeStringForStringFieldShouldSetDefaultToSomeString()
    {
        $dictOptions = array(
            "default" => "Some string."
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::STRING);
        $this->assertEquals("Some string.", $fieldOption->getDefault());
    }

    public function testDefaultOfSomeStringForIntegerFieldShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictOptions = array(
            "default" => "Some string."
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::INTEGER);
        $fieldOption->check();
    }

    public function testDefaultOptionForDateFieldShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictOptions = array(
            "default" => "Something"
        );
        $fieldOption = new FieldOptions($dictOptions, FieldTypeEnum::DATE);
        $fieldOption->check();
    }
}
