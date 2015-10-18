<?php

namespace App\Jobs\Tournament;
use App\Models\Match;
use App\Models\Tournament;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Collection;

class DrawKnockOut extends Job implements SelfHandling
{
    const LIST_OF_AVAILABLE_TEAMS_AMOUNT = [2, 4, 8, 16, 32, 64];

    /**
     * @var Collection
     */
    protected $teams;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $matches;

    /**
     * @var int
     */
    protected $round;

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

        $this->teams = $this->teams->shuffle();
        $this->matches = Match::where('tournamentId', $this->tournament->id);

        $this->determineRound();
    }

    protected function determineRound()
    {
        if ($this->matches->count() === 0) {
            $this->round = 1;
        } else {
            // @todo
            throw new \RuntimeException('Next rounds draw is not ready yet.');
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

        if (!in_array(count($this->teams), self::LIST_OF_AVAILABLE_TEAMS_AMOUNT)) {
            throw new \UnexpectedValueException('Amount of teams should be a 2, 4, 8, 16, 32 or 64.');
        }

        $this->draw();
    }

    public function draw()
    {
        $pairs = $this->getPairs();

        $this->savePairs($pairs);
    }

    protected function getPairs()
    {
        $pairs = $this->teams->chunk(2);

        return $pairs;
    }

    /**
     * @param $pairs
     */
    protected function savePairs($pairs)
    {
        $defaults = [
            'tournamentId' => $this->tournament->id,
            'homeScore' => 0,
            'awayScore' => 0,
            'homePenaltyScore' => 0,
            'awayPenaltyScore' => 0,
            'round' => $this->round,
            'gameType' => Match::GAME_TYPE_QUALIFY,
            'resultType' => Match::RESULT_TYPE_UNKNOWN,
            'status' => Match::STATUS_NOT_STARTED
        ];

        foreach ($pairs as $pair) {
            Match::create(
                array_merge($defaults, [
                    'homeTournamentTeamId' => array_get($pair->first(), 'id'),
                    'awayTournamentTeamId' => array_get($pair->last(), 'id'),
                ])
            );
        }

        foreach ($pairs as $pair) {
            Match::create(
                array_merge($defaults, [
                    'awayTournamentTeamId' => array_get($pair->first(), 'id'),
                    'homeTournamentTeamId' => array_get($pair->last(), 'id'),
                ])
            );
        }
    }
}
