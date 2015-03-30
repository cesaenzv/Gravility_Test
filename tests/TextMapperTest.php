<?php

use App\Models\CubeProcessor\TextMapper;


class TextMapperTest extends TestCase
{
	public function test_Empty(){
		$this->setExpectedException('\App\Models\Utils\CustomGravilityException', 'Linea no valida para objeto de Operación');
		TextMapper::OperationMapper('');
		$this->setExpectedException('\App\Models\Utils\CustomGravilityException', 'Linea no valida para objeto de Test');
		TextMapper::TestMapper('');
	}

	public function test_typeOfObject(){
		$this->assertInstanceOf('App\Models\Entities\UserCase', TextMapper::UserCaseMapper('4 5'));
		$this->assertInstanceOf('App\Models\Entities\Operation', TextMapper::OperationMapper('UPDATE 2 2 2 4'));
	}
}