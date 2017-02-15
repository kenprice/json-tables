# Change Log

## [0.3.0] 2017-02-14
 - Added new method to `JsonTables`: `JsonTables::generateAssetsFromSchema($schema, $dbConfig)`, which generates SQL assets from `JsonTables\Schema\Schema` objects.
 - `JsonTables\Schema\Schema` now validates itself in its constructor. It will throw `JsonTables\Exceptions\InvalidSchemaException` if the parsed JSON schema is invalid.
 - <3

## [0.2.0] 2017-02-11
### Added
 - Support for `autoincrement` and `default` field options.
   - `autoincrement` (boolean) can be added to your JSON table schema in any integer field.
   - `default` (integer|string) can be added to your JSON table schema in any integer or string field. The default option sets a default value for your table column.