<?php

use JsonTables\Schema\Constraints;

class ConstraintsTest extends PHPUnit_Framework_TestCase
{
    public function testEmptyDictInConstructorShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array();
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
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

    public function testRequiredGarbageShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "required" => "garbage"
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
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

    public function testUniqueGarbageInConstructorShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "unique" => "garbage"
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
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

    public function testMinLengthOfNegativeIntShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "minLength" => "-1"
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
    }

    public function testMinLengthOfBlankShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "minLength" => ""
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
    }

    public function testMinLengthOfGarbageShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "minLength" => "garbage"
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
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

    public function testMaxLengthOfNegativeIntShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "maxLength" => "-1"
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
    }

    public function testMaxLengthOfBlankShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "maxLength" => ""
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
    }

    public function testMaxLengthOfGarbageShouldErrorOnValidation()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictConstraints = array(
            "maxLength" => "garbage"
        );
        $constraints = new Constraints($dictConstraints);
        $constraints->check();
    }
}
