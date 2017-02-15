# json-tables
Use JSON Table Schema-like JSON files to create and validate tables. In other words, take a JSON string like this:

```json
{
  "tables": [
    {
      "name": "users",
      "fields": [
        {
          "name": "id",
          "type": "integer",
          "constraints": {
            "unique": true
          },
          "options": {
            "autoincrement": true
          }
        },
        {
          "name": "username",
          "type": "string",
          "constraints": {
            "unique": true
          }
        },
        {
          "name": "password",
          "type": "string",
          "constraints": {
            "minLength": 16
          }
        }
      ],
      "primaryKey": "id"
    }
  ]
}
```

...and create tables from it! Validation is performed against the JSON table schema given as input. 

## Usage

Example usage. 

```php
<?php
use JsonTables\JsonTables;

$jsonPath = 'docs/sample-schema.json';
$jsonSchema = file_get_contents($jsonPath);
$dbConfig = array(
    'path' => 'database.sqlite',
    'driver' => 'pdo_sqlite'
);
JsonTables::generateAssetsFromJsonTable($jsonSchema, $dbConfig);
```
`$dbConfig` is a [Doctrine DBAL configuration](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html). The SQLite PDO driver is used in the example above.
 
Try it with `docs/sample-schema.json`!

You can also create your own `\JsonTables\Schema\Schema` object and generate SQL assets from it. Like so:

```php
<?php
use JsonTables\JsonTables;
use JsonTables\Schema;

$jsonPath = 'docs/sample-schema.json';
$schema = new Schema\Schema(file_get_contents($jsonPath));
$dbConfig = array(
    'path' => 'database.sqlite',
    'driver' => 'pdo_sqlite'
);
JsonTables::generateAssetsFromSchema($schema, $dbConfig);
```

## Installation

```
composer require kenprice/json-tables
```

## Notes

Work in progress! See `/docs` for example schema and basic API docs, and see `CHANGELOG.md` for the latest changes.
