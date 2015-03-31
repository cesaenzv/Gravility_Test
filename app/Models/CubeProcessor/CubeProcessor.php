<?php namespace App\Models\CubeProcessor;

use App\Models\Utils\CustomGravilityException;
use App\Models\CubeProcessor\AOperationProcessor;
use App\Models\CubeProcessor\UpdateOperation;
use App\Models\CubeProcessor\QueryOperation;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;
use Exception;

class CubeProcessor {

	/**
	 * Procesa todo el input entregado por el usuario
	 *
	 * @param  Input    $_i  Input ingresado por el usuario y transformado en objeto
	 * @return Input    $_i  Input calculado
	 */ 
	public function ProcessCube($_i){
		try{
			foreach ($_i->usercases as $_c) {
				$_caseText = '';
				$matrix = array();
				foreach ($_c->operations as $_o) {
					$processor = $this->_getOperationProcessor($_c,$_o);
					$matrix = $processor->ProcessOperation($matrix);
				}
				foreach ($_c->operations as $_o) {
					if($_o->result != '')
						$_caseText = $_caseText.$_o->result."\n";
				}
				$_c->result = $_caseText;
				$_c->save();
			}
			$_i->outMessage = "Proceso Calculo Completo";
			$_i->passed = true;
			return $_i;
		}
		catch(CustomGravilityException $ex){
			$_i->outMessage = $ex->getMessage();
			$_i->passed = false;
		}
		catch(Exception $ex){
			$_i->outMessage = "CubeProcesor Error inesperado - ".$ex->getMessage();
			$_i->passed = false;
		}
		$_i->save();
		return $_i;
	}

	/**
	 * Does something interesting
	 *
	 * @param  UserCase   $_c  Where something interesting takes place
	 * @param  Operation  $_o How many times something interesting should happen
	 * @throws CustomGravilityException Si no hay procesador para esta operación
	 * @return Status
	 */ 
	private function _getOperationProcessor ($_c,$_o){
		switch($_o->operationTypeId){
			case 1:
				return new UpdateOperation($_c,$_o);
				break;
			case 2:
				return new QueryOperation($_c,$_o);
				break;
			default:
				throw new CustomGravilityException('Operación a procesar no contemplada');				
				break;
		}
	}

}