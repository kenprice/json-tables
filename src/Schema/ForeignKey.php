<?php

namespace JsonTables\Schema;

use JsonTables\Exceptions;
use JsonTables\Notification;

class ForeignKey
{
    private $_field;
    private $_dictReferences;
    private $_referencesResource;
    private $_referencesField;

    /**
     * ForeignKey constructor.
     */
    public function __construct($dictForeignKey)
    {
        if (array_key_exists('fields', $dictForeignKey)) {
            $this->_field = $dictForeignKey["fields"];
        }
        if (array_key_exists('reference', $dictForeignKey)) {
            $this->_dictReferences = $dictForeignKey["reference"];
        }
        if (array_key_exists('resource', $this->_dictReferences)) {
            $this->_referencesResource = $this->_dictReferences["resource"];
        }
        if (array_key_exists('fields', $this->_dictReferences)) {
            $this->_referencesField = $this->_dictReferences["resource"];
        }
    }

    public function check()
    {
        if ($this->validation()->hasErrors()) {
            throw new Exceptions\InvalidSchemaException(
                $this->validation()->errorMessages('Invalid ForeignKey')
            );
        }
    }

    public function validation(Notification $note = null)
    {
        $note = $note ?? new Notification();
        if ($this->_field === null) {
            $note->addError('"fields" is required.');
        }
        if ($this->_referencesResource === null) {
            $note->addError('"resource" in "reference" is required.');
        }
        if ($this->_referencesField === null) {
            $note->addError('"fields" in "reference" is required.');
        }
    }
}