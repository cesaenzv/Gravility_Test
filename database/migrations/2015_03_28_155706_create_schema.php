<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchema extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Define tables
		Schema::create('Input',function($table){
			$table->increments('id');						
		});
		Schema::create('UserCase',function($table){
			$table->increments('id');
		});
		Schema::create('OperationType',function($table){
			$table->increments('id');
		});
		Schema::create('Operation',function($table){
			$table->increments('id');
		});

		//Define Attributes
		Schema::table('Input', function($table)
		{
		    $table->string('userText');
		    $table->boolean('passed');
		    $table->string('outMessage');
		});
		
		Schema::table('usercase', function($table)
		{
		    $table->integer('matrix');
			$table->integer('num_oper');
			$table->string('result');
			$table->integer('inputId')->unsigned();
			$table->foreign('inputId')->references('id')->on('Input');
		});
		Schema::table('OperationType', function($table)
		{
			$table->string('description');
		});
		Schema::table('Operation', function($table)
		{
			$table->string('operationText');
			$table->string('result');
			$table->integer('operationTypeId')->unsigned();
			$table->foreign('operationTypeId')->references('id')->on('OperationType');
			$table->integer('testId')->unsigned();
			$table->foreign('testId')->references('id')->on('usercase');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
