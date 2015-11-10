<?php

namespace App\Serializers\Tournament;

use App\Models\Match;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class TablescoresSerializer
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
                'position' => 0,
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
                        'name' => $match->homeTournamentTeam->team->name,
                    ],
                    $defaultTeamData
                );
            }

            if (!$awayTeam) {
                $awayTeam = array_merge(
                    [
                        'teamId' => $match->awayTournamentTeam->id,
                        'name' => $match->awayTournamentTeam->team->name,
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
                        $awayTeam['points'] += Match::POINTS_WIN;

                        break;
                    case Match::RESULT_TYPE_DRAW:
                        $homeTeam['draws']++;
                        $awayTeam['draws']++;
                        $homeTeam['points'] += Match::POINTS_DRAW;
                        $awayTeam['points'] += Match::POINTS_DRAW;

                        break;
                }
            }

            $tablescore->put($match->homeTournamentTeam->id, $homeTeam);
            $tablescore->put($match->awayTournamentTeam->id, $awayTeam);

        });


        // sort by points and goal difference
        $tablescore = $tablescore->sort(function($a, $b) {
            if ($b['points'] === $a['points']) {
                return $b['goalsDifference'] - $a['goalsDifference'];
            }

            return $b['points'] - $a['points'];
        });

        $previousRow = null;
        $position = 1;
        $tablescore = $tablescore->map(function($row) use (&$previousRow, &$position) {
            if ($previousRow
                && $previousRow['points'] > 0
                && $previousRow['points'] == $row['points']
                && $previousRow['goalsDifference'] == $row['goalsDifference']
                && $previousRow['goalsScored'] == $row['goalsScored']
            ) {
                $row['position'] = $previousRow['position'];
            } else {
                $row['position'] = $position;
            }

            $position++;

            $previousRow = $row;

            return $row;
        });

        // alphabetical sort for teams on the same position
        $tablescore = $tablescore->sortBy(function($team) {
            return $team['position'] . '-' . $team['name'];
        }, SORT_NUMERIC);

        return $tablescore;
    }
}