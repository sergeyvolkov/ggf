<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model {

	protected $table = 'tournaments';

	protected $fillable = ['name','description'];

	public $timestamps = true;

	public function tournamentTeams()
	{
		return $this->hasMany(TournamentTeam::class, 'tournamentId');
	}

}