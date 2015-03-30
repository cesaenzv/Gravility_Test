<?php namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
	
	protected $table = 'operation';
	public $timestamps = false;
	protected $fillable = array('operationText', 'operationTypeId', 'testId');

	protected $operationData = null;

	public function operationType(){
		return $this->hasOne('App\Models\Entities\OperationType','operationTypeId');
	}

	public function getOperationData()
	{
		if($operationData == null) $operationData = explode(" ",$this->operationText);
		return $operationData;
	}

}