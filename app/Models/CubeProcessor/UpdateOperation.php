<?php namespace App\Models\CubeProcessor;

use App\Models\Utils\CustomGravilityException;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;

class UpdateOperation extends AOperationBuilder{

	public function ValidateText(){
		$_arr =explode(' ', $this->_o->operationText);
		for($i = 0; $i<3; $i++){
			if( $_arr[$i]< 1 || $_arr[$i]>$this->_c->matrix)
				throw new CustomGravilityException("Error de Operacion - Coordenadas - ".$this->_o->operationText);	
		}
		if($_arr[3] < pow(-10, 9) || $_arr[3] > pow(10, 9))
				throw new CustomGravilityException("Error de Operacion - Valor - ".$this->_o->operationText);	
		return $_arr;
	}

	public function CalculateValueOperation($_arr, &$matrix){
		$matrix[$_arr[0].' '.$_arr[1].' '.$_arr[2]] = $_arr[3];
		return '';
	}
}
