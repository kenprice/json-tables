<?php

namespace JsonTables;

use JsonTables\Helpers\StringHelper;

class Constraints
{
    private $_required;
    private $_minLength;
    private $_maxLength;
    private $_unique;

    /**
     * Constraints constructor.
     * @param array $dictConstraints Constraints as associative array
     * @throws Exceptions\InvalidSchemaException
     */
    public function __construct($dictConstraints)
    {
        if (!$dictConstraints) {
            throw new Exceptions\InvalidSchemaException('"constraints" cannot be empty.');
        }

        if (array_key_exists(ConstraintTypeEnum::REQUIRED, $dictConstraints)) {
            $this->_required = StringHelper::parseBool($dictConstraints[ConstraintTypeEnum::REQUIRED]);
            if ($this->_required === null) {
                throw new Exceptions\InvalidSchemaException('"required" must be a boolean.');
            }
        }

        if (array_key_exists(ConstraintTypeEnum::MIN_LENGTH, $dictConstraints)) {

            $this->_minLength = StringHelper::parseIntNonNegative($dictConstraints[ConstraintTypeEnum::MIN_LENGTH]);
            if ($this->_minLength === null) {
                throw new Exceptions\InvalidSchemaException('"minLength" must be an integer.');
            }
        }

        if (array_key_exists(ConstraintTypeEnum::MAX_LENGTH, $dictConstraints)) {
            $this->_maxLength = StringHelper::parseIntNonNegative($dictConstraints[ConstraintTypeEnum::MAX_LENGTH]);
            if ($this->_maxLength === null) {
                throw new Exceptions\InvalidSchemaException('"maxLength" must be an integer.');
            }
        }

        if (array_key_exists(ConstraintTypeEnum::UNIQUE, $dictConstraints)) {
            $this->_unique = StringHelper::parseBool($dictConstraints[ConstraintTypeEnum::UNIQUE]);
            if ($this->_unique === null) {
                throw new Exceptions\InvalidSchemaException('"unique" must be a boolean.');
            }
        }
    }

    public function getRequired()
    {
        return $this->_required === true;
    }

    public function getUnique()
    {
        return $this->_unique === true;
    }

    public function getMinLength()
    {
        return $this->_minLength;
    }

    public function getMaxLength()
    {
        return $this->_maxLength;
    }
}