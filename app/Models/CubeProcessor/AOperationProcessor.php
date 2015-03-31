<?php namespace App\Models\CubeProcessor;

use App\Models\Utils\CustomGravilityException;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;
use Exception;

abstract class AOperationProcessor {

	public $_o;
	protected $_c;

	function __construct($case, $ope){
		$this->_c = $case;
		$this->_o = $ope;
	}
	/**
	 * Metodo que ejecuta el procesamiento de la operación
	 *
	 * @param  array   $_matrix  Matriz de información del caso de pruebas
	 * @return array   $_matrix  Matriz de información del caso de pruebas
	 */ 
	public function ProcessOperation($matrix){
		$_arr = $this->ValidateText();
		$this->_o->result=$this->CalculateValueOperation($_arr, $matrix);
		$this->_o->save();
		return $matrix;
	}

	/**
	 * Metodo encargado de validar el texto de la operación
	 *
	 * @throws CustomGravilityException Si la información de la operación no es correcta
	 * @return void
	 */ 
	abstract protected function ValidateText();

	/**
	 * Does something interesting
	 *
	 * @param  array   $_arr  Input ingresado por el usuario y transformado en objeto
	 * @param  array   &$_matrix  Matriz de información del caso de pruebas
	 * @return String  Mensaje resultante de la operación
	 */ 
	abstract protected function CalculateValueOperation($_arr, &$matrix);

}


