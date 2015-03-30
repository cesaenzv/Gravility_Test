<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Debug\Debug;
use App\Models\Entities\Operationtype;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Debug::enable();
		$this->call('OperationTypeSeeder');		
	}

}

class OperationTypeSeeder extends Seeder {

	public function run()
	{
		DB::table('operationtype')->delete();
		Operationtype::create(array('description' => 'UPDATE'));
		Operationtype::create(array('description' => 'QUERY'));
	}

}

