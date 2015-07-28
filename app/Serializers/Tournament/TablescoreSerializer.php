<?php

namespace App\Serializers\Tournament;

use App\Models\Match;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class TablescoreSerializer
{
    /**
     * @return Collection
     */
    public function collection(EloquentCollection $collection)
    {
        $tablescore = new Collection();

        $collection->map(function($match) use ($tablescore) {

            $homeTeam = $tablescore->pull($match->homeTournamentTeam->id);
            $awayTeam = $tablescore->pull($match->awayTournamentTeam->id);

            $defaultTeamData = [
                'matches' => 0,
                'rank' => 0,
                'wins' => 0,
                'draws' => 0,
                'losts' => 0,
                'points' => 0,
                'goalsScored' => 0,
                'goalsAgainsted' => 0,
                'goalsDifference' => 0,
            ];

            if (!$homeTeam) {
                $homeTeam = array_merge(
                    [
                        'teamId' => $match->homeTournamentTeam->id,
                    ],
                    $defaultTeamData
                );
            }

            if (!$awayTeam) {
                $awayTeam = array_merge(
                    [
                        'teamId' => $match->awayTournamentTeam->id,
                    ],
                    $defaultTeamData
                );
            }

            if (Match::STATUS_FINISHED == $match->status) {
                $homeTeam['matches']++;
                $awayTeam['matches']++;
                $homeTeam['goalsScored'] += $match->homeScore;
                $homeTeam['goalsAgainsted'] += $match->awayScore;
                $homeTeam['goalsDifference'] = ($homeTeam['goalsScored'] - $homeTeam['goalsAgainsted']);

                $awayTeam['goalsScored'] += $match->awayScore;
                $awayTeam['goalsAgainsted'] += $match->homeScore;
                $awayTeam['goalsDifference'] = ($awayTeam['goalsScored'] - $awayTeam['goalsAgainsted']);

                switch ($match->resultType) {
                    case Match::RESULT_TYPE_HOME_WIN:
                        $homeTeam['wins']++;
                        $homeTeam['points'] += Match::POINTS_WIN;
                        $awayTeam['losts']++;

                        break;
                    case Match::RESULT_TYPE_AWAY_WIN:
                        $awayTeam['wins']++;
                        $homeTeam['losts']++;

                        break;
                    case Match::RESULT_TYPE_DRAW:
                        $homeTeam['draws']++;
                        $homeTeam['points'] += Match::POINTS_WIN;
                        $awayTeam['points'] += Match::POINTS_WIN;

                        break;
                }
            }

            $tablescore->put($match->homeTournamentTeam->id, $homeTeam);
            $tablescore->put($match->awayTournamentTeam->id, $awayTeam);

        });

        $tablescore = $tablescore->sort(function($a, $b) {
            if ($b['points'] === $a['points']) {
                return $b['goalsDifference'] - $a['goalsDifference'];
            }

            return $b['points'] - $a['points'];
        });

        return $tablescore;
    }
}