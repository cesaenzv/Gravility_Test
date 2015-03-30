<?php namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Operationtype extends Model
{
	
	public $timestamps = false;
	protected $table = 'operationtype';
	protected $fillable = array('description');

}