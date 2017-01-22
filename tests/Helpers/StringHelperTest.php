<?php

use JsonTables\Helpers\StringHelper;

class StringHelperTest extends PHPUnit_Framework_TestCase
{
    public function testStringIsAlphaNumDashUnderscoreAcceptsAlphaOnly()
    {
        $this->assertTrue(
            StringHelper::stringIsAlphaNumDashUnderscore("test")
        );
    }

    public function testStringIsAlphaNumDashUnderscoreAcceptsAlphaMixedCase()
    {
        $this->assertTrue(
            StringHelper::stringIsAlphaNumDashUnderscore("TeStInG")
        );
    }

    public function testStringIsAlphaNumDashUnderscoreAcceptsAlphaNum()
    {
        $this->assertTrue(
            StringHelper::stringIsAlphaNumDashUnderscore("test1")
        );
    }

    public function testStringIsAlphaNumDashUnderscoreAcceptsAlphaUnderscore()
    {
        $this->assertTrue(
            StringHelper::stringIsAlphaNumDashUnderscore("test_ing")
        );
    }

    public function testStringIsAlphaNumDashUnderscoreRejectsSpecialChars()
    {
        $this->assertFalse(
            StringHelper::stringIsAlphaNumDashUnderscore("test!?")
        );
    }

    public function testStringIsAlphaNumDashUnderscoreRejectsBlank()
    {
        $this->assertFalse(
            StringHelper::stringIsAlphaNumDashUnderscore("")
        );
    }
}
