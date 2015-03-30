<?php namespace App\Models\TextManager;

use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Utils\CustomGravilityException;
use App\Models\TextManager\TextMapper;

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
			for($l = 0; $l<$_testCases;$l++ ){
				$lin = trim(array_shift($lines));
				$_u = TextMapper::UserCaseMapper($lin);
				$_u->inputId = $input->id;
				$_u->save();
				for($i=0; $i<$_u->num_oper; $i++){
					$lin = trim(array_shift($lines));
					$_o = TextMapper::OperationMapper($lin);
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