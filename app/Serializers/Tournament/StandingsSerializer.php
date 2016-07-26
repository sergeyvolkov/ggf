<?php

namespace App\Serializers\Tournament;

use App\Models\Match;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class StandingsSerializer
{
    /**
     * @return Collection
     */
    public function collection(EloquentCollection $matches)
    {
        $standings = new Collection();

        $matches = $matches->sortBy('id');

        $matches->map(function($match) use ($standings) {

            $pairId = [$match->homeTournamentTeam->id, $match->awayTournamentTeam->id];
            sort($pairId);
            $pairId = implode('-', $pairId);

            $pair = $standings->pull($pairId);

            if (!$pair) {
                $pair = [
                    'id' => $pairId,
                    'tournamentId' => $match->tournamentId,
                    'round' => $match->round,
                    'homeTeamId' => $match->homeTournamentTeam->id,
                    'homeTeamName' => $match->homeTournamentTeam->team->name,
                    'awayTeamId' => $match->awayTournamentTeam->id,
                    'awayTeamName' => $match->awayTournamentTeam->team->name,
                    'matches' => []
                ];
            }

            $pair['matches'][] = $match['id'];

            sort($pair['matches']);

            $standings->put($pairId, $pair);
        });

        return $standings;
    }
}