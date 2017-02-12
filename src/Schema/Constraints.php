<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Helpers\StringHelper;
use JsonTables\IValidate;
use JsonTables\Notification;

class Constraints implements IValidate
{
    /**
     * @var array Associative array for the Constraints, generated from JSON schema
     */
    private $_dictConstraints;
    /**
     * @var bool Set when field is not nullable
     */
    private $_required;
    /**
     * @var int Minimum length, if field is a string
     */
    private $_minLength;
    /**
     * @var int Maximum length, if field is a string
     */
    private $_maxLength;
    /**
     * @var bool Set when field is unique
     */
    private $_unique;

    /**
     * Constraints constructor.
     * @param array $dictConstraints Constraints as associative array
     */
    public function __construct($dictConstraints)
    {
        $this->_dictConstraints = $dictConstraints;
        if (array_key_exists(ConstraintTypeEnum::REQUIRED, $dictConstraints)) {
            $this->_required = StringHelper::parseBool($dictConstraints[ConstraintTypeEnum::REQUIRED]);
        }
        if (array_key_exists(ConstraintTypeEnum::MIN_LENGTH, $dictConstraints)) {

            $this->_minLength = StringHelper::parseIntNonNegative($dictConstraints[ConstraintTypeEnum::MIN_LENGTH]);
        }
        if (array_key_exists(ConstraintTypeEnum::MAX_LENGTH, $dictConstraints)) {
            $this->_maxLength = StringHelper::parseIntNonNegative($dictConstraints[ConstraintTypeEnum::MAX_LENGTH]);
        }
        if (array_key_exists(ConstraintTypeEnum::UNIQUE, $dictConstraints)) {
            $this->_unique = StringHelper::parseBool($dictConstraints[ConstraintTypeEnum::UNIQUE]);
        }
    }

    public function check()
    {
        if ($this->validation()->hasErrors()) {
            throw new Exceptions\InvalidSchemaException(
                $this->validation()->errorMessages('Invalid Constraints')
            );
        }
    }

    public function validation(Notification $note = null)
    {
        $note = $note ?? new Notification();
        if (array_key_exists(ConstraintTypeEnum::REQUIRED, $this->_dictConstraints)
            && $this->_required === null) {
            $note->addError('"required" must be a boolean.');
        }
        if (array_key_exists(ConstraintTypeEnum::MIN_LENGTH, $this->_dictConstraints)
            && $this->_minLength === null) {
            $note->addError('"minLength" must be an integer.');
        }
        if (array_key_exists(ConstraintTypeEnum::MAX_LENGTH, $this->_dictConstraints)
            && $this->_maxLength === null) {
            $note->addError('"maxLength" must be an integer.');
        }
        if (array_key_exists(ConstraintTypeEnum::UNIQUE, $this->_dictConstraints)
            && $this->_unique === null) {
            $note->addError('"unique" must be a boolean.');
        }
        if ($this->_required === null
            && $this->_minLength === null
            && $this->_maxLength === null
            && $this->_unique === null) {
            $note->addError('"constraints" cannot be empty.');
        }
        return $note;
    }

    /**
     * @return bool
     */
    public function getRequired()
    {
        return $this->_required === true;
    }

    /**
     * @return bool
     */
    public function getUnique()
    {
        return $this->_unique === true;
    }

    /**
     * @return int|mixed
     */
    public function getMinLength()
    {
        return $this->_minLength;
    }

    /**
     * @return int|mixed
     */
    public function getMaxLength()
    {
        return $this->_maxLength;
    }
}