<?php namespace App\Models\Entities;

use App\Models\Entities\Input;
use App\Models\Entities\Test;
use App\Models\Entities\Operation;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
	
	public $timestamps = false;
	protected $table = 'input';
	protected $fillable = array('userText','state','outMessage');

	public function usercases(){
		return $this->hasMany('App\Models\Entities\UserCase', 'inputId', 'id');
	}

}