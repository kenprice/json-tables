<?php

namespace JsonTables;

use MabeEnum\Enum;

class ConstraintTypeEnum extends Enum
{
    const REQUIRED = "required";
    const MIN_LENGTH = "minLength";
    const MAX_LENGTH = "maxLength";
    const UNIQUE = "unique";
}
