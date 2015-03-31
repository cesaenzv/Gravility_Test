<?php namespace App\Models\TextManager;

use App\Models\Utils\CustomGravilityException;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;
use Exception;

class TextMapper {

	/**
	 * Metodo estatico encargado de procesar string y retornar objeto de tipo Operation
	 *
	 * @param  String   $line  Texto ingresado por el usuario
	 * @throws CustomGravilityException Si el texto es incorrecto
	 * @return Input 	Objeto resultante del texto procesado
	 */ 
	public static function OperationMapper($line){
		$_arr = explode(" ", $line);
		if(self::_checkArrayEmpty($_arr))
			throw new CustomGravilityException("Linea no valida para objeto de Operación -".$line);
		$operationType = Operationtype::where('description',$_arr[0])->first();
		if($operationType == null)
			throw new CustomGravilityException("No se tiene registrada esta operación en el sistema -".$line);			
		$operation = new Operation();
		$operation->operationText = trim(str_replace($_arr[0],"",$line));
		$operation->operationTypeId = $operationType->id;
		return $operation; 
	}

	/**
	 * Metodo estatico encargado de procesar string y retornar objeto de tipo UserCase
	 *
	 * @param  String   $line  Texto ingresado por el usuario
	 * @throws CustomGravilityException Si el texto es incorrecto
	 * @return Input  UserCase resultante del texto procesado
	 */ 
	public static function UserCaseMapper($line){
		$_arr = explode(" ", $line);
		if(self::_checkArrayEmpty($_arr))
			throw new CustomGravilityException("Linea no valida para objeto de Test -".$line);
		$test = new UserCase();
		$test->matrix = intval($_arr[0]);			
		$test->num_oper = intval($_arr[1]);
		if($test->matrix >100 || $test->matrix < 1) 
			throw new CustomGravilityException("La matriz definida no cumple los criterios -".$line);
		if($test->num_oper >1000 || $test->num_oper < 1) 
			throw new CustomGravilityException("La cantidad de operaciones no cumple con los criterios -".$line);
		return $test;
	}

	/**
	 * Metodo encargado de validar si el array tiene un elementos vacios
	 *
	 * @param  array  $_arr  Array resultande del string procesado
	 * @return bool  
	 */ 
	private static function _checkArrayEmpty($_arr){
		return (count(array_filter(array_map('trim',$_arr), 'strlen' )) < count($_arr));
	}

}