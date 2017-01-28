<?php

namespace JsonTables\Schema;

use MabeEnum\Enum;

/**
 * Class ConstraintTypeEnum
 * Enumerates accepted constraint types
 * @package JsonTables\Schema
 */
class ConstraintTypeEnum extends Enum
{
    const REQUIRED = "required";
    const MIN_LENGTH = "minLength";
    const MAX_LENGTH = "maxLength";
    const UNIQUE = "unique";
}
