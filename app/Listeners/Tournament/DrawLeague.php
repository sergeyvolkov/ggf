<?php

namespace App\Listeners\Tournament;

use App\Events\TournamentWasStarted;
use App\Models\Match;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection;

class DrawLeague
{
    /**
     * @var Tournament
     */
    protected $tournament;

    /**
     * @var Collection
     */
    protected $teams;

    /**
     * @var Collection
     */
    protected $rounds;

    /**
     * @var Collection
     */
    protected $matches;

    /**
     * @var boolean
     */
    protected $isOdd = false;

    /**
     * @var int
     */
    protected $teamsCount;

    /**
     * @var int
     */
    protected $pairCnt;

    /**
     * @var Collection
     */
    protected $season;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->teams = new Collection();
    }


    protected function setTournament($tournament)
    {
        $this->tournament = $tournament;

        foreach ($this->tournament->tournamentTeams()->getResults() as $team) {
            $team->team->homeMatchesAmount = 0;
            $team->team->wasPulledOut = false;
            $team->team->pulledOut = false;
            $this->teams->push([
                'id' => $team->id,
                'name' => $team->team->name
            ]);
        }

        $this->teamsCount =  $this->teams->count();
        $this->isOddTeamsCnt();
        $this->setPairCnt();
    }

    /**
     * Handle the event.
     *
     * @param  Events $event
     * @return void
     */
    public function handle(TournamentWasStarted $event)
    {
        $this->setTournament($event->tournament);

        if (Tournament::MIN_TEAMS_AMOUNT > $this->teams->count()) {
            throw new \UnexpectedValueException('Tournament should have at least 2 teams.');
        }

        /**
         * @var $matches Collection
         */
        $matches = $this->tournament->matches()->getResults();

        if (0 < $matches->count()) {
            throw new \UnexpectedValueException('Tournament draw has been already done.');
        }

        $this->draw();
    }

    /**
     * @name draw
     */
    protected function draw()
    {

        $this->rounds = $this->drawBergerTable();
        $this->teams = $this->teams->reverse();

        $this->rounds = array_merge($this->rounds, $this->drawBergerTable());

        $this->saveRounds();
    }

    /**
     * Create scheduling for one season by Berger algorithm https://en.wikipedia.org/wiki/Round-robin_tournament
     * @name drawBergerTable
     * @return array
     */
    protected function drawBergerTable()
    {
        $table = [];
        for ( $i=0; $i<$this->teamsCount-1; $i++) {
            $table[$i] = [];

            if (!$this->isOdd) {
                $table[$i][] = [
                    'homeTournamentTeamId' => $this->teams[0]['id'],
                    'homeTeamName'         => $this->teams[0]['name'],
                    'awayTournamentTeamId' => $this->teams[$this->teamsCount - 1]['id'],
                    'awayTeamName'         => $this->teams[$this->teamsCount - 1]['name'],
                ];
            }

            for ( $j=1; $j<$this->pairCnt; $j++) {
                $table[$i][] =  [
                        'homeTournamentTeamId' => $this->teams[$j]['id'],
                        'homeTeamName'         => $this->teams[$j]['name'],
                        'awayTournamentTeamId' => $this->teams[$this->teamsCount - 1 - $j]['id'],
                        'awayTeamName'         => $this->teams[$this->teamsCount - 1 - $j]['name'],
                    ];
            }
            $this->teams->push($this->teams->shift());
        }

        return $table;
    }

    /**
     * Check if teams is odd count
     * @name isOddTeamsCnt
     */
    protected function isOddTeamsCnt()
    {
        if ($this->teamsCount%2 != 0) {
            $this->isOdd =  true;
            $this->teamsCount++;
        }
    }

    /**
     * @name setPairCnt
     */
    protected function setPairCnt()
    {
        $this->pairCnt = intval($this->teamsCount/2);
    }

    /**
     * @name saveRounds
     */
    protected function saveRounds()
    {
        foreach ($this->rounds as $key => $round) {
            foreach ($round as $match) {
                Match::create([
                    'tournamentId' => $this->tournament->id,
                    'homeTournamentTeamId' => $match['homeTournamentTeamId'],
                    'awayTournamentTeamId' => $match['awayTournamentTeamId'],
                    'homeScore' => 0,
                    'awayScore' => 0,
                    'homePenaltyScore' => 0,
                    'awayPenaltyScore' => 0,
                    'round' => $key + 1,
                    'gameType' => Match::GAME_TYPE_GROUP_STAGE,
                    'resultType' => Match::RESULT_TYPE_UNKNOWN,
                    'status' => Match::STATUS_NOT_STARTED
                ]);
            }
        }
    }
}
