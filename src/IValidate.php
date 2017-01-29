<?php

namespace JsonTables;

interface IValidate
{
    /**
     * Throws exception if validation fails.
     */
    public function check();

    /**
     * Adds error messages to Notification object if a validation check fails.
     * @param Notification|null $note
     * @return mixed
     */
    public function validation(Notification $note = null);
}