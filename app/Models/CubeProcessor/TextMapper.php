<?php namespace App\Models\CubeProcessor;

use App\Models\Utils\CustomGravilityException;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;

class TextMapper {

	public static function OperationMapper($line){
		$_arr = explode(" ", $line);
		if(self::_checkArrayEmpty($_arr))
			throw new CustomGravilityException('Linea no valida para objeto de Operación');
		$operationType = Operationtype::where('description',$_arr[0])->first();
		if($operationType == null)
			throw new CustomGravilityException("No se tiene registrada esta operación en el sistema");			
		$operation = new Operation();
		$operation->operationText = trim(str_replace($_arr[0],"",$line));
		$operation->operationTypeId = $operationType->id;
		return $operation; 
	}

	public static function UserCaseMapper($line){
		$_arr = explode(" ", $line);
		if(self::_checkArrayEmpty($_arr))
			throw new CustomGravilityException("Linea no valida para objeto de Test");
		$test = new UserCase();
		$test->matrix = intval($_arr[0]);			
		$test->num_oper = intval($_arr[1]);
		if($test->matrix >100 || $test->matrix < 1) 
			throw new CustomGravilityException("La matriz definida no cumple los criterios");
		if($test->num_oper >1000 || $test->num_oper < 1) 
			throw new CustomGravilityException("La cantidad de operaciones no cumple con los criterios");
		return $test;
	}

	private static function _checkArrayEmpty($_arr){
		return (count(array_filter(array_map('trim',$_arr), 'strlen' )) < count($_arr));
	}

}