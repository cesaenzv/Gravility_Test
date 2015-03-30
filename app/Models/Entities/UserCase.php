<?php namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class UserCase extends Model
{
	
	protected $table = 'UserCase';
	public $timestamps = false;
	protected $fillable = array('matrix', 'num_oper','result');

	public function operations(){
		return $this->hasMany('App\Models\Entities\Operation','testId','id');
	}
}