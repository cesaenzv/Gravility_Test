<?php namespace App\Models\CubeProcessor;

use App\Models\Utils\CustomGravilityException;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;
use App\Models\Entities\Operation;
use App\Models\Entities\Operationtype;
use Illuminate\Database\Eloquent\Model;

abstract class AOperationBuilder {

	public $_o;
	protected $_c;

	function __construct($case, $ope){
		$this->_c = $case;
		$this->_o = $ope;
	}

	public function ProcessOperation($matrix){
		$_arr = $this->ValidateText();
		$this->_o->result=$this->CalculateValueOperation($_arr, $matrix);
		$this->_o->save();
		return $matrix;
	}

	abstract protected function ValidateText();
	abstract protected function CalculateValueOperation($_arr, &$matrix);

}


