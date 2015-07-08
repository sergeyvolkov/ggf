<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentTeam extends Model {

	protected $table = 'tournament_teams';
	public $timestamps = false;

	public function tournament()
	{
		return $this->belongsTo('Tournament');
	}

	public function team()
	{
		return $this->belongsTo('Team');
	}

}