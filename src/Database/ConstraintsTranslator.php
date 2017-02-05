<?php

namespace JsonTables\Database;

use JsonTables\Schema\Constraints;

/**
 * Class ConstraintsTranslator
 * Translates Schema\Constraints object to array of portable options for Doctrine DBAL
 * @package JsonTables\Database
 */
class ConstraintsTranslator
{
    /**
     * @param Constraints $constraints
     * @return array Portable options for Doctrine DBAL schema
     */
    public static function translate(Constraints $constraints)
    {
        $output = array(
            'notnull' => $constraints->getRequired(),
            'customSchemaOptions' => array(
                'unique' => $constraints->getUnique()
            )
        );
        if ($constraints->getMaxLength()) {
            $output['length'] = $constraints->getMaxLength();
        }
        return $output;
    }
}
