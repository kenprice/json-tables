## Table of contents

- [\JsonTables\IValidate (interface)](#interface-jsontablesivalidate)
- [\JsonTables\Notification](#class-jsontablesnotification)
- [\JsonTables\JsonTables](#class-jsontablesjsontables)
- [\JsonTables\Database\AssetGenerator](#class-jsontablesdatabaseassetgenerator)
- [\JsonTables\Database\ConstraintsTranslator](#class-jsontablesdatabaseconstraintstranslator)
- [\JsonTables\Exceptions\InvalidSchemaException](#class-jsontablesexceptionsinvalidschemaexception)
- [\JsonTables\Exceptions\InvalidJsonException](#class-jsontablesexceptionsinvalidjsonexception)
- [\JsonTables\Helpers\StringHelper](#class-jsontableshelpersstringhelper)
- [\JsonTables\Schema\Table](#class-jsontablesschematable)
- [\JsonTables\Schema\FieldTypeEnum](#class-jsontablesschemafieldtypeenum)
- [\JsonTables\Schema\Schema](#class-jsontablesschemaschema)
- [\JsonTables\Schema\ConstraintTypeEnum](#class-jsontablesschemaconstrainttypeenum)
- [\JsonTables\Schema\Constraints](#class-jsontablesschemaconstraints)
- [\JsonTables\Schema\ForeignKey](#class-jsontablesschemaforeignkey)
- [\JsonTables\Schema\Field](#class-jsontablesschemafield)

<hr /> 
### Interface: \JsonTables\IValidate

| Visibility | Function |
|:-----------|:---------|
| public | <strong>check()</strong> : <em>void</em><br /><em>Throws exception if validation fails.</em> |
| public | <strong>validation(</strong><em>[\JsonTables\Notification](#class-jsontablesnotification)/null/[\JsonTables\Notification](#class-jsontablesnotification)</em> <strong>$note=null</strong>)</strong> : <em>mixed</em><br /><em>Adds error messages to Notification object if a validation check fails.</em> |

<hr /> 
### Class: \JsonTables\Notification

> Class Notification - Stores error notifications (e.g. validation errors, anywhere where exceptions may not be appropriate).

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed/array</em> <strong>$errors=null</strong>)</strong> : <em>void</em><br /><em>Notification constructor.</em> |
| public | <strong>addError(</strong><em>\string</em> <strong>$message</strong>)</strong> : <em>void</em> |
| public | <strong>errorMessages(</strong><em>mixed</em> <strong>$strHead=null</strong>)</strong> : <em>void</em> |
| public | <strong>hasErrors()</strong> : <em>bool</em> |

<hr /> 
### Class: \JsonTables\JsonTables

> Class JsonTables

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>generateAssetsFromJsonTable(</strong><em>string</em> <strong>$jsonSchema</strong>, <em>array</em> <strong>$dbConfig</strong>)</strong> : <em>void</em><br /><em>Generates tables for the database specified in $dbConfig. Table schemas are generated from the JSON Schema specified in $path.</em> |

<hr /> 
### Class: \JsonTables\Database\AssetGenerator

> Class AssetGenerator

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\JsonTables\Schema\Schema](#class-jsontablesschemaschema)</em> <strong>$schema</strong>, <em>\Doctrine\DBAL\Driver\Connection</em> <strong>$conn</strong>)</strong> : <em>void</em><br /><em>AssetGenerator constructor.</em> |
| public | <strong>generate()</strong> : <em>void</em><br /><em>Generates tables from JSON table schema.</em> |

<hr /> 
### Class: \JsonTables\Database\ConstraintsTranslator

> Class ConstraintsTranslator Translates Schema\Constraints object to array of portable options for Doctrine DBAL

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>translate(</strong><em>[\JsonTables\Schema\Constraints](#class-jsontablesschemaconstraints)</em> <strong>$constraints</strong>)</strong> : <em>array Portable options for Doctrine DBAL schema</em> |

<hr /> 
### Class: \JsonTables\Exceptions\InvalidSchemaException

> Indicates that a schema is invalid

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$message</strong>, <em>mixed</em> <strong>$code</strong>, <em>\JsonTables\Exceptions\Exception</em> <strong>$previous=null</strong>)</strong> : <em>void</em> |

*This class extends \Exception*

*This class implements \Throwable*

<hr /> 
### Class: \JsonTables\Exceptions\InvalidJsonException

> Indicates that an invalid JSON string was attempting to be used.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$message</strong>, <em>mixed</em> <strong>$code</strong>, <em>\JsonTables\Exceptions\Exception</em> <strong>$previous=null</strong>)</strong> : <em>void</em> |

*This class extends \Exception*

*This class implements \Throwable*

<hr /> 
### Class: \JsonTables\Helpers\StringHelper

> Various helper functions for regex testing and possibly other things

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>parseBool(</strong><em>\string</em> <strong>$str</strong>)</strong> : <em>mixed</em><br /><em>Parses input to bool. Null if invalid. Note: Blank string will return false.</em> |
| public static | <strong>parseIntNonNegative(</strong><em>\string</em> <strong>$str</strong>)</strong> : <em>mixed</em><br /><em>Parses input to non-negative integer. Null if invalid.</em> |
| public static | <strong>stringIsAlphaNumDashUnderscore(</strong><em>\string</em> <strong>$str</strong>)</strong> : <em>bool</em><br /><em>Returns true if string only contains alphanumeric characters, plus dash and underscore</em> |

<hr /> 
### Class: \JsonTables\Schema\Table

> Class Table

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$dictTable</strong>)</strong> : <em>void</em><br /><em>Table constructor. and foreignKeys</em> |
| public | <strong>check()</strong> : <em>void</em> |
| public | <strong>getFields()</strong> : <em>[\JsonTables\Schema\Field](#class-jsontablesschemafield)[]</em> |
| public | <strong>getForeignKeys()</strong> : <em>[\JsonTables\Schema\ForeignKey](#class-jsontablesschemaforeignkey)[]</em> |
| public | <strong>getName()</strong> : <em>mixed/string</em> |
| public | <strong>getPrimaryKey()</strong> : <em>mixed/string</em> |
| public | <strong>validation(</strong><em>[\JsonTables\Notification](#class-jsontablesnotification)</em> <strong>$note=null</strong>)</strong> : <em>void</em> |

*This class implements [\JsonTables\IValidate](#interface-jsontablesivalidate)*

<hr /> 
### Class: \JsonTables\Schema\FieldTypeEnum

> Class FieldTypeEnum Enumerates accepted field types

| Visibility | Function |
|:-----------|:---------|

*This class extends \MabeEnum\Enum*

<hr /> 
### Class: \JsonTables\Schema\Schema

> Class Schema

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\string</em> <strong>$jsonSchema</strong>)</strong> : <em>void</em><br /><em>Schema constructor. Builds schema from a JSON Schema</em> |
| public | <strong>check()</strong> : <em>void</em> |
| public | <strong>getTables()</strong> : <em>[\JsonTables\Schema\Table](#class-jsontablesschematable)[]</em> |
| public | <strong>validation(</strong><em>[\JsonTables\Notification](#class-jsontablesnotification)</em> <strong>$note=null</strong>)</strong> : <em>void</em> |

*This class implements [\JsonTables\IValidate](#interface-jsontablesivalidate)*

<hr /> 
### Class: \JsonTables\Schema\ConstraintTypeEnum

> Class ConstraintTypeEnum Enumerates accepted constraint types

| Visibility | Function |
|:-----------|:---------|

*This class extends \MabeEnum\Enum*

<hr /> 
### Class: \JsonTables\Schema\Constraints

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$dictConstraints</strong>)</strong> : <em>void</em><br /><em>Constraints constructor.</em> |
| public | <strong>check()</strong> : <em>void</em> |
| public | <strong>getMaxLength()</strong> : <em>int/mixed</em> |
| public | <strong>getMinLength()</strong> : <em>int/mixed</em> |
| public | <strong>getRequired()</strong> : <em>bool</em> |
| public | <strong>getUnique()</strong> : <em>bool</em> |
| public | <strong>validation(</strong><em>[\JsonTables\Notification](#class-jsontablesnotification)</em> <strong>$note=null</strong>)</strong> : <em>void</em> |

*This class implements [\JsonTables\IValidate](#interface-jsontablesivalidate)*

<hr /> 
### Class: \JsonTables\Schema\ForeignKey

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$dictForeignKey</strong>)</strong> : <em>void</em><br /><em>ForeignKey constructor.</em> |
| public | <strong>check()</strong> : <em>void</em> |
| public | <strong>getField()</strong> : <em>mixed/string</em> |
| public | <strong>getReferencedField()</strong> : <em>mixed/string</em> |
| public | <strong>getReferencedResource()</strong> : <em>mixed/string</em> |
| public | <strong>validation(</strong><em>[\JsonTables\Notification](#class-jsontablesnotification)</em> <strong>$note=null</strong>)</strong> : <em>void</em> |

*This class implements [\JsonTables\IValidate](#interface-jsontablesivalidate)*

<hr /> 
### Class: \JsonTables\Schema\Field

> Class Field

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$dictField</strong>)</strong> : <em>void</em><br /><em>Field constructor.</em> |
| public | <strong>check()</strong> : <em>void</em> |
| public | <strong>getConstraints()</strong> : <em>[\JsonTables\Schema\Constraints](#class-jsontablesschemaconstraints)</em> |
| public | <strong>getDescription()</strong> : <em>mixed/string</em> |
| public | <strong>getFormat()</strong> : <em>mixed</em> |
| public | <strong>getName()</strong> : <em>mixed/string</em> |
| public | <strong>getTitle()</strong> : <em>mixed/string</em> |
| public | <strong>getType()</strong> : <em>[\JsonTables\Schema\FieldTypeEnum](#class-jsontablesschemafieldtypeenum)/mixed</em> |
| public | <strong>validation(</strong><em>[\JsonTables\Notification](#class-jsontablesnotification)</em> <strong>$note=null</strong>)</strong> : <em>void</em> |

*This class implements [\JsonTables\IValidate](#interface-jsontablesivalidate)*

