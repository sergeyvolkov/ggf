<?php

namespace App\Models;

class League extends Model {

	protected $table = 'leagues';

	protected $fillable = ['name','logoPath', 'leagueId'];

	public $timestamps = false;

	public function teams()
	{
		return $this->hasMany(Team::class, 'leagueId');
	}

}