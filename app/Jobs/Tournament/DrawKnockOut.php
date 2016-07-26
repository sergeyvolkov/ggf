<?php

namespace App\Jobs\Tournament;
use App\Models\Match;
use App\Models\Tournament;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Debug\Dumper;

class DrawKnockOut extends Job implements SelfHandling
{
    /**
     * @var Collection
     */
    protected $teams;

    /**
     * @var EloquentCollection
     */
    protected $matches;

    /**
     * @var int
     */
    protected $round;

    /**
     * @return array
     */
    static function listOfAvailableTeamsAmount()
    {
        return [2, 4, 8, 16, 32, 64];
    }

    protected function setTournament(Tournament $tournament)
    {
        $this->teams = new Collection();
        $this->tournament = $tournament;

        foreach ($this->tournament->tournamentTeams()->getResults() as $team) {
            $this->teams->push([
                'id' => $team->id,
                'name' => $team->team->name
            ]);
        }

        $this->round = $tournament->getCurrentRound() + 1;
    }

    protected function determineRound()
    {
        if ($this->tournament->matches()->get()->count() === 0) {
            $this->round = 1;
        } else {
            $this->round = $this->tournament->currentRound() + 1;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Tournament::MIN_TEAMS_AMOUNT > count($this->teams)) {
            throw new \UnexpectedValueException('Tournament should have at least 2 teams.');
        }

        if (!in_array(count($this->teams), self::listOfAvailableTeamsAmount())) {
            throw new \UnexpectedValueException('Amount of teams should be a 2, 4, 8, 16, 32 or 64.');
        }

        $this->draw();
    }

    public function draw()
    {
        $pairs = $this->getPairs();

        if ($pairs->count() > 0 && $pairs->get(0)->count() > 1) {
            $gameType = Match::GAME_TYPE_QUALIFY;

            // set game type to `final` when there is only 1 pair left in the tournament
            if ($this->round !== 1 && 1 === $pairs->count()) {
                $gameType = Match::GAME_TYPE_FINAL;
            }

            $this->savePairs($pairs, $gameType);
        }
    }

    /**
     * @return Collection
     */
    protected function getPairs()
    {
        $round = $this->round;
        $tournament = $this->tournament;

        if (1 === $round) {
            $this->teams = $this->teams->shuffle();

            $pairs = $this->teams->chunk(2);

            return $pairs;
        } else {
            $currentPairs = $tournament->getPairs()->filter(function($pair) use ($round) {
                return $pair->get('round') === $round - 1;
            });

            $roundWinners = new Collection();

            $currentPairs->each(function($pair) use ($tournament, $roundWinners) {
                // detect pair winner
                $roundWinners->push($tournament->getScore($pair->get('matches'))->first());
            });

            return $this->teams->filter(function($team) use ($roundWinners) {
                return $roundWinners->pluck('teamId')->contains($team['id']);
            })->chunk(2);
        }
    }

    /**
     * @param $pairs
     */
    protected function savePairs($pairs, $gameType = Match::GAME_TYPE_QUALIFY)
    {
        $defaults = [
            'homeScore' => 0,
            'awayScore' => 0,
            'homePenaltyScore' => 0,
            'awayPenaltyScore' => 0,
            'round' => $this->round,
            'gameType' => $gameType,
            'resultType' => Match::RESULT_TYPE_UNKNOWN,
            'status' => Match::STATUS_NOT_STARTED
        ];

        foreach ($pairs as $pair) {
            $this->tournament->matches()->create(
                array_merge($defaults, [
                    'homeTournamentTeamId' => array_get($pair->first(), 'id'),
                    'awayTournamentTeamId' => array_get($pair->last(), 'id'),
                ])
            );
        }

        // generate reverse matches only for match with `qualify` type
        if (Match::GAME_TYPE_QUALIFY === $gameType) {
            foreach ($pairs as $pair) {
                $this->tournament->matches()->create(
                    array_merge($defaults, [
                        'awayTournamentTeamId' => array_get($pair->first(), 'id'),
                        'homeTournamentTeamId' => array_get($pair->last(), 'id'),
                    ])
                );
            }
        }
    }
}
