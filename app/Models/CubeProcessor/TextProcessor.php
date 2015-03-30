<?php namespace App\Models\CubeProcessor;

use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Utils\CustomGravilityException;
use App\Models\CubeProcessor\TextMapper;

class TextProcessor {

	public function ValidateText($inputText){		
		$input = new Input();
		$input->userText = $inputText;
		try{			
			$lines = explode("\n", $inputText);		
			$_testCases = array_shift($lines);
			$input->save();
			if($_testCases < 1 || $_testCases > 50){
				throw new CustomGravilityException("Número de casos de pruebas no aceptados");		
			}
			for($l = $_testCases; $l>0; $l-- ){
				$_u = TextMapper::UserCaseMapper(array_shift($lines));
				$_u->inputId = $input->id;
				$_u->save();
				for($i=$_u->num_oper; $i>0; $i--){
					$_o = TextMapper::OperationMapper(array_shift($lines));
					$_o->testId = $_u->id;
					$_o->save();
				}	
			}		
			$input->passed = true;
			$input->outMessage = "Proceso Lectura Completo";
		}
		catch(CustomGravilityException $ex){
			$input->outMessage = $ex->getMessage();
			$input->passed = false;
		}
		catch(Exception $ex){
			$input->outMessage = "Error inesperado - ".$ex->getMessage();
			$input->passed = false;
		}
		$input->save();
		return $input;
	}
}