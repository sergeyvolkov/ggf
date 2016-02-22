<?php

namespace App\Jobs\Tournament;

use App\Models\Match;
use App\Models\Tournament;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\Collection;

class DrawLeague extends Job implements SelfHandling
{
    /**
     * @var Array
     */
    protected $teams = [];

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

    protected function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;

        foreach ($this->tournament->tournamentTeams()->getResults() as $team) {
            $team->team->homeMatchesAmount = 0;
            $team->team->wasPulledOut = false;
            $team->team->pulledOut = false;
            array_push($this->teams, [
                'id' => $team->id,
                'name' => $team->team->name
            ]);
        }

        shuffle($this->teams);

        $this->teamsCount = count($this->teams);
        $this->isOddTeamsCnt();
        $this->setPairCnt();
    }

    /**
     * Handle the job
     *
     * @return void
     */
    public function handle()
    {
        if (Tournament::MIN_TEAMS_AMOUNT > count($this->teams)) {
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
        $table = $this->drawBergerTable();

        $this->saveRounds($table);
    }

    /**
     * Create scheduling for one season by Berger algorithm https://en.wikipedia.org/wiki/Round-robin_tournament
     * @name drawBergerTable
     * @return array
     */
    protected function drawBergerTable()
    {
        $a = [];
        $table = [];

        for ($i = 1; $i < $this->teamsCount; $i++) {
            $a[] = $i;
        }

        for ($i = 0; $i < $this->teamsCount - 1; $i++) {
            $table[$i] = [];
            if (!$this->isOdd) {
                $table[$i][] = [$a[0], $this->teamsCount];
            }
            for ($j = 1; $j < $this->pairCnt; $j++) {
                $table[$i][] = [$a[$j], $a[$this->teamsCount - 1 - $j]];
            }
            array_push($a, array_shift($a));
        }

        $table = $this->addReversMarches($table);

        return $table;
    }

    /**
     * @name addReversMarches
     * @param $table
     * @return array
     */
    protected function addReversMarches($table)
    {
        for ($i = count($table) - 1; $i >= 0; $i--) {
            $day = $table[$i];

            $nDay = [];
            foreach ($day as $match) {
                $nDay[] = [$match[1], $match[0]];
            }
            $table[] = $nDay;
        }

        return $table;
    }

    /**
     * Check if teams is odd count
     * @name isOddTeamsCnt
     */
    protected function isOddTeamsCnt()
    {
        if ($this->teamsCount % 2 != 0) {
            $this->isOdd = true;
            $this->teamsCount++;
        }
    }

    /**
     * @name setPairCnt
     */
    protected function setPairCnt()
    {
        $this->pairCnt = intval($this->teamsCount / 2);
    }

    /**
     * @name saveRounds
     */
    protected function saveRounds($table)
    {
        foreach ($table as $key => $round) {
            foreach ($round as $match) {
                $this->tournament->matches()->create([
                    'homeTournamentTeamId' => $this->teams[$match[0] - 1]['id'],
                    'awayTournamentTeamId' => $this->teams[$match[1] - 1]['id'],
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
