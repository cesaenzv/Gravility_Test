<?php namespace App\Models\CubeProcessor;

use App\Models\CubeProcessor\AOperationProcessor;
use App\Models\Utils\CustomGravilityException;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;
use Exception;

class QueryOperation extends AOperationProcessor{

	public function ValidateText(){
		$_arr =explode(' ', $this->_o->operationText);
		for($i = 0; $i<3; $i++){
			if($_arr[$i+3] > $this->_c->matrix || $_arr[$i]<1 || $_arr[$i]>$_arr[$i+3]){
				throw new CustomGravilityException("Error de Operacion - Coordenadas - ".$this->_o->operationText);	
			}
		}
		return $_arr;
	}
	
	public function CalculateValueOperation($_arr, &$matrix){
		$result = 0;
		for($i=$_arr[0]; $i<=$_arr[3]; $i++){
			for($j=$_arr[1]; $j<=$_arr[4]; $j++){
				for($k=$_arr[2]; $k<=$_arr[5]; $k++){
					if(isset($matrix[$i.' '.$j.' '.$k])){
						$result += intval($matrix[$i.' '.$j.' '.$k]);
					}					
				}
			}
		}
		return "".$result."";
	}
}