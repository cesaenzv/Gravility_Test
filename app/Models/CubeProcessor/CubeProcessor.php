<?php namespace App\Models\CubeProcessor;

use App\Models\Utils\CustomGravilityException;
use App\Models\CubeProcessor\AOperationBuilder;
use App\Models\CubeProcessor\UpdateOperation;
use App\Models\CubeProcessor\QueryOperation;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;

class CubeProcessor {

	public function ProcessCube($_i){
		try{
			//$cases = UserCase::where('inputId',$_i->id)->orderBy('id')->get();
			foreach ($_i->usercases as $_c) {
				$_caseText = '';
				$matrix = array();
				//$opers = Operation::where('testId',$_c->id)->orderBy('id')->get();
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
			$_i->outMessage = "Error inesperado - ".$ex->getMessage();
			$_i->passed = false;
		}
		$_i->save();
		return $_i;
	}

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