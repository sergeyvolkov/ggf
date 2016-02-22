<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Tournament extends Model
{
    protected $table = 'tournaments';

    protected $fillable = ['name', 'description', 'status', 'type', 'membersType'];

    public $timestamps = true;

    const MEMBERS_TYPE_SINGLE = 'single';
    const MEMBERS_TYPE_DOUBLE = 'double';

    const TYPE_LEAGUE = 'league';
    const TYPE_KNOCK_OUT = 'knock_out';
    const TYPE_MULTISTAGE = 'multistage';

    const STATUS_DRAFT = 'draft';
    const STATUS_STARTED = 'started';
    const STATUS_COMPLETED = 'completed';

    const MIN_TEAMS_AMOUNT = 2;

    public function tournamentTeams()
    {
        return $this->hasMany(TournamentTeam::class, 'tournamentId');
    }

    public function matches()
    {
        return $this->hasMany(Match::class, 'tournamentId');
    }

    /**
     * @return array
     */
    static public function getAvailableMembersType()
    {
        return [
            self::MEMBERS_TYPE_SINGLE,
            self::MEMBERS_TYPE_DOUBLE,
        ];
    }

    /**
     * @return array
     */
    static public function getAvailableTypes()
    {
        return [
            self::TYPE_LEAGUE,
            self::TYPE_KNOCK_OUT,
            self::TYPE_MULTISTAGE
        ];
    }

    /**
     * @return array
     */
    static public function getAvailableStatuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_STARTED,
            self::STATUS_COMPLETED
        ];
    }

    /**
     * Group matches in tournament into pairs
     *
     * @return Collection
     */
    public function getPairs()
    {
        // get pairs of current round matches
        $pairs = new Collection();

        $this->matches->map(function($match) use ($pairs) {

            $pairId = [$match->homeTournamentTeam->id, $match->awayTournamentTeam->id];
            sort($pairId);
            $pairId = implode('-', $pairId);

            $pair = $pairs->pull($pairId);

            if (!$pair) {
                $teams = new Collection([$match->homeTournamentTeam->with('Team')->get(), $match->awayTournamentTeam->with('Team')->get()]);

                $pair = new Collection([
                    'id' => $pairId,
                    'round' => $match->round,
                    'teams' => $teams,
                    'matches' => new Collection()
                ]);
            }

            $pair->get('matches')->push($match);

            $pairs->put($pairId, $pair);
        });

        return $pairs;
    }

    /**
     *
     * @todo Make a refactoring for `pair` entity
     *
     * @param $matches
     */
    public function getScore(Collection $matches)
    {
        $score = new Collection();

        $matches->map(function($match) use ($score) {

            $homeTeam = $score->pull($match->homeTournamentTeam->id);
            $awayTeam = $score->pull($match->awayTournamentTeam->id);

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

            $score->put($match->homeTournamentTeam->id, $homeTeam);
            $score->put($match->awayTournamentTeam->id, $awayTeam);

        });


        // sort by points and goal difference
        $score = $score->sort(function($a, $b) {
            if ($b['points'] === $a['points']) {
                return $b['goalsDifference'] - $a['goalsDifference'];
            }

            return $b['points'] - $a['points'];
        });

        $previousRow = null;
        $position = 1;
        $score = $score->map(function($row) use (&$previousRow, &$position) {
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
        $score = $score->sortBy(function($team) {
            return $team['position'] . '-' . $team['name'];
        }, SORT_NUMERIC);

        return $score;
    }

    /**
     * @param Collection $matches
     */
    public function getWinner(Collection $matches)
    {
        return $this->getScore($matches)->first();
    }

    public function getCurrentRound()
    {
        $matches = $this->matches()->get();

        if ($matches->count() === 0) {
            return 0;
        } else {
            return $matches->pluck('round')->max();
        }
    }
}