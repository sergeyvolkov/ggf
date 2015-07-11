<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentTeam extends Model
{

    protected $table = 'tournament_teams';

    protected $fillable = ['tournamentId','teamId'];

    public $timestamps = false;

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournamentId');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'teamId');
    }

}