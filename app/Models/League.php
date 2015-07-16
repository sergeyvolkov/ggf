<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model {

	protected $table = 'leagues';

	protected $fillable = ['name','logoPath'];

	public $timestamps = false;

}