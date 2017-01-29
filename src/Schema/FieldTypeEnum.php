<?php

namespace JsonTables\Schema;

use MabeEnum\Enum;

/**
 * Class FieldTypeEnum
 * Enumerates accepted field types
 * @package JsonTables\Schema
 */
class FieldTypeEnum extends Enum
{
    const STRING = "string";
    const NUMBER = "number";
    const INTEGER = "integer";
    const BOOLEAN = "boolean";
    const OBJECT = "object";
    const ARRAY = "array";
    const DATE = "date";
}