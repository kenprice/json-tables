<?php

namespace JsonTables;

use MabeEnum\Enum;

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