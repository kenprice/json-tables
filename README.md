# json-tables
Use JSON Table Schema-like JSON files to create and validate tables. In other words, take a JSON string like this:

```
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

...and create tables from it!

## Usage

```
$jsonPath = 'sample-schema.json';
$jsonSchema = file_get_contents($jsonPath);
$dbConfig = array(
    'path' => 'database.sqlite',
    'driver' => 'pdo_sqlite'
);
JsonTables::generateAssetsFromJsonTable($jsonSchema, $dbConfig);
```

## Installation

```
composer require kenprice/json-tables
```

## Notes

Work in progress! See docs for example schema and basic API docs.
