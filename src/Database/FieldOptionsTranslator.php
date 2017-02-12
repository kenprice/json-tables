<?php

namespace JsonTables\Database;

use JsonTables\Schema\FieldOptions;

/**
 * Class FieldOptionsTranslator
 * Translates Schema\FieldOptions object to array of portable options for Doctrine DBAL
 * @package JsonTables\Database
 */
class FieldOptionsTranslator
{
    /**
     * @param FieldOptions $fieldOptions
     * @return array Portable options for the Doctrine DBAL schema
     */
    public static function translate(FieldOptions $fieldOptions)
    {
        $output = [];
        $autoIncrement = $fieldOptions->getAutoincrement();
        $default = $fieldOptions->getDefault();
        if ($autoIncrement) {
            $output['autoincrement'] = $fieldOptions->getAutoincrement();
        }
        if ($default) {
            $output['default'] = $fieldOptions->getDefault();
        }
        return $output;
    }
}
