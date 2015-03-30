<?php

/**
* 
*/
class DataBaseTest extends TestCase
{
	public function testConnection(){

		$dbName = DB::connection()->getDatabaseName();
		$this->assertEquals("gravility", $dbName);
	}
}