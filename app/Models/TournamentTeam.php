<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;

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

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class, 'tournamentTeamId', 'teamId');
    }
}