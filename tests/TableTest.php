<?php

use JsonTables\Schema\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionOnEmptyArray()
    {
        $this->expectException(JsonTables\Exceptions\InvalidSchemaException::class);
        $dictTable = array();
        $table = new Table($dictTable);
        $table->check();
    }
}
