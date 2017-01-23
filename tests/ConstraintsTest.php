<?php

use JsonTables\Schema\Constraints;

class ConstraintsTest extends PHPUnit_Framework_TestCase
{
    public function testEmptyDictInConstructorShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array();
        new Constraints($dictConstraints);
    }

    public function testRequiredTrueInConstructorShouldSetRequired()
    {
        $dictConstraints = array(
            "required" => "true"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertTrue($constraints->getRequired());
    }

    public function testRequiredFalseInConstructorShouldUnSetRequired()
    {
        $dictConstraints = array(
            "required" => "false"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertFalse($constraints->getRequired());
    }

    public function testRequiredBlankInConstructorShouldUnsetRequired()
    {
        $dictConstraints = array(
            "required" => ""
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertFalse($constraints->getRequired());
    }

    public function testRequiredGarbageInConstructorShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "required" => "garbage"
        );
        new Constraints($dictConstraints);
    }

    public function testUniqueTrueInConstructorShouldSetRequired()
    {
        $dictConstraints = array(
            "unique" => "true"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertTrue($constraints->getUnique());
    }

    public function testUniqueFalseInConstructorShouldUnSetRequired()
    {
        $dictConstraints = array(
            "unique" => "false"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertFalse($constraints->getUnique());
    }

    public function testUniqueBlankInConstructorShouldUnsetRequired()
    {
        $dictConstraints = array(
            "unique" => ""
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertFalse($constraints->getUnique());
    }

    public function testUniqueGarbageInConstructorShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "unique" => "garbage"
        );
        new Constraints($dictConstraints);
    }

    public function testMinLengthOfZeroShouldSetMinLengthToZero()
    {
        $dictConstraints = array(
            "minLength" => "0"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertEquals($constraints->getMinLength(), 0);
    }

    public function testMinLengthOfIntShouldSetMinLengthToInt()
    {
        $dictConstraints = array(
            "minLength" => "1337"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertEquals($constraints->getMinLength(), 1337);
    }

    public function testMinLengthOfNegativeIntShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "minLength" => "-1"
        );
        new Constraints($dictConstraints);
    }

    public function testMinLengthOfBlankShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "minLength" => ""
        );
        new Constraints($dictConstraints);
    }

    public function testMinLengthOfGarbageShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "minLength" => "garbage"
        );
        new Constraints($dictConstraints);
    }

    public function testMaxLengthOfZeroShouldSetMaxLengthToZero()
    {
        $dictConstraints = array(
            "maxLength" => "0"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertEquals($constraints->getMaxLength(), 0);
    }

    public function testMaxLengthOfIntShouldSetMaxLengthToInt()
    {
        $dictConstraints = array(
            "maxLength" => "1337"
        );
        $constraints = new Constraints($dictConstraints);
        $this->assertEquals($constraints->getMaxLength(), 1337);
    }

    public function testMaxLengthOfNegativeIntShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "maxLength" => "-1"
        );
        new Constraints($dictConstraints);
    }

    public function testMaxLengthOfBlankShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "maxLength" => ""
        );
        new Constraints($dictConstraints);
    }

    public function testMaxLengthOfGarbageShouldThrowException()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "maxLength" => "garbage"
        );
        new Constraints($dictConstraints);
    }
}
