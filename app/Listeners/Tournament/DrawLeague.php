<?php

namespace App\Listeners\Tournament;

use App\Events\TournamentWasStarted;
use App\Models\Match;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;

class DrawLeague
{
    const MAX_LEAGUE_DRAW_TRIES = 20;
    const MAX_ROUND_DRAW_TRIES = 100;

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
     * @var int
     */
    protected $roundsPerTeam;

    /**
     * @var int
     */
    protected $tournamentRoundsNumber;

    /**
     * @var Collection
     */
    protected $matches;

    /**
     * @var bool
     */
    protected $needToPullOut;

    /**
     * @var int
     */
    protected $leagueDrawsTries     ;

    /**
     * @var int
     */
    protected $roundDrawTries;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->teams = new Collection();
        $this->leagueDrawsTries = 0;
        $this->roundDrawTries = 0;

        $this->reset();
    }

    protected function reset()
    {
        $this->rounds = new Collection();
        $this->matches = new Collection();
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

        // first shuffle
        $this->teams = $this->shuffle($this->teams);

        $this->roundsPerTeam = ($this->teams->count() - 1) * 2;
        $this->roundsPerLap = $this->teams->count() % 2 ? $this->teams->count() : $this->teams->count() - 1;
        $this->tournamentMatchesNumber = ($this->teams->count() - 1) * $this->teams->count();
        $this->needToPullOut = (bool)($this->teams->count() % 2);

        Log::debug('Rounds per team: ' . $this->roundsPerTeam);
        Log::debug('Rounds per lap: ' . $this->roundsPerLap);
        Log::debug('Total matches: ' . $this->tournamentMatchesNumber);
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

    protected function draw()
    {
        try {
            $this->leagueDrawsTries++;

            for ($i = 0; $i < $this->roundsPerLap; $i++) {
                $this->drawRound($i);
            }

            $this->reverseRounds();

            Log::info("Success draw with \"$this->leagueDrawsTries\" draws and \"$this->roundDrawTries\" tries.");

            $this->saveRounds();

        } catch (DrawLeagueException $e) {
//            if (self::MAX_LEAGUE_DRAW_TRIES < $this->leagueDrawsTries) {
//                Log::error('League draws: ' . $this->leagueDrawsTries);
//                Log::error('Round draws: ' . $this->roundDrawTries);
//                throw new \RuntimeException($e->getMessage());
//            }

            $this->reset();

            // shuffle the teams collection and retry
            $this->teams = $this->shuffle($this->teams);

            return $this->draw();
        }
    }

    protected function shuffle($collection)
    {
        $new = $collection->slice(1)->shuffle();
        $new->push($collection->first());

        return $new;
    }


    protected function shift($collection)
    {
        $new = $collection->slice(1);
        $new->push($collection->first());

        return $new;
    }

    protected function drawRound($roundIndex)
    {
        $teams = clone $this->teams;

        if ($this->needToPullOut) {
            $this->pullTeamOut($roundIndex, $teams);
        }

        $matches = $this->collectMatches($teams);
        $this->rounds->push($matches);

    }

    protected function pullTeamOut($roundIndex, Collection &$teams)
    {
        if ($roundIndex >= $teams->count()) {
            $roundIndex = $roundIndex - $teams->count();
        }

        $teams->forget($roundIndex);

        $teams = $teams->values();

        return $teams;
    }

    protected function collectMatches($teams)
    {
        $matches = new Collection();

        $pairs = $this->getPairs($teams);

        foreach ($pairs as $pair) {
            $homeTeam = $pair->first();
            $awayTeam = $pair->last();

            $keys = [array_get($homeTeam, 'id'), array_get($awayTeam, 'id')];
            sort($keys);

            $this->matches->push(join(':', $keys));

            $matches->push([
                'homeTournamentTeamId' => array_get($homeTeam, 'id'),
                'homeTeamName' => array_get($homeTeam, 'name'),
                'awayTournamentTeamId' => array_get($awayTeam, 'id'),
                'awayTeamName' => array_get($awayTeam, 'name'),
            ]);
        }
        return $matches;
    }

    protected function getPairs($teams, $tries = 0)
    {
        $pairs = new Collection();
        $i = 0;

        while ($i < $teams->count()) {
            $pairs->push($teams->slice($i, 2));

            $i += 2;
        }

        $isCorrectPairs = true;
        $this->roundDrawTries++;

        $pairs->each(function($pair) use (&$isCorrectPairs) {
            if (!$this->teamsCanPlay($pair->first(), $pair->last())) {
                $isCorrectPairs = false;
            }
        });

        if (self::MAX_ROUND_DRAW_TRIES < $tries) {
            throw new DrawLeagueException('Max round draw tries: ' . $tries);
        }

        if (!$isCorrectPairs) {
            $tries++;

            // shuffle the teams collection and retry
            return $this->getPairs($this->shuffle($teams), $tries);
        }

        return $pairs;

    }

    protected function teamsCanPlay($homeTeam, $awayTeam)
    {
        if (array_get($homeTeam, 'name') === array_get($awayTeam, 'name')) {
            return false;
        }

        $keys = [array_get($homeTeam, 'id'), array_get($awayTeam, 'id')];
        sort($keys);

        if (false !== $this->matches->search(join(':', $keys))) {
            return false;
        }

        return true;
    }

    protected function reverseRounds()
    {
        foreach ($this->rounds->reverse() as $round) {
            $matches = new Collection();

            foreach ($round->all() as $match) {
                $matches->push([
                    'homeTournamentTeamId' => $match['awayTournamentTeamId'],
                    'homeTeamName' => $match['awayTeamName'],
                    'awayTournamentTeamId' => $match['homeTournamentTeamId'],
                    'awayTeamName' => $match['homeTeamName'],
                ]);
            }

            $this->rounds->push($matches);
        }
    }

    protected function saveRounds()
    {
        foreach ($this->rounds->all() as $key => $round) {
            foreach ($round->all() as $match) {
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
