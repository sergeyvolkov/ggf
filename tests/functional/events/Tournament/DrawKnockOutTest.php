<?php

namespace App\Tests\Unit\Events\Tournament;

use App\Models\Match;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Events\TournamentWasStarted;

use App\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laracasts\TestDummy\Factory;

class DrawKnockOutTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @param $teamsAmount
     * @param $matcheAmount
     *
     * @dataProvider tournamentTeamsProvider
     */
    public function testKnockOutDrawWithDifferrentTeamsAmount($teamsAmount, $matchesAmount, $expectedException = null)
    {
        /**
         * @var $tournament Tournament
         */
        $tournament = Factory::create('App\Models\Tournament', [
            'type' => Tournament::TYPE_KNOCK_OUT
        ]);

        /**
         * @var $tournament Tournament
         */
        $league = Factory::create('App\Models\League');

        Factory::times($teamsAmount)->create('App\Models\Team', ['leagueId' => $league->id])
            ->each(function($team, $key) use ($tournament) {
                $tournament->tournamentTeams()->create([
                    'teamId' => $team->id,
                    'tournamentId' => $tournament->id,
                ]);
            });

        if ($expectedException) {
            $this->setExpectedException($expectedException);
        }

        $tournament->status = Tournament::STATUS_STARTED;
        $tournament->save();

        $this->assertTrue($tournament instanceof Tournament);
        // verify total matches amount
        $this->assertEquals($matchesAmount, $tournament->matches()->getResults()->count());
    }

    public function tournamentTeamsProvider()
    {
        return [
            [
                'teamsAmount' => 3,
                'matchesCount' => 2,
                'expectedException' => \UnexpectedValueException::class
            ],
            [
                'teamsAmount' => 2,
                'matchesCount' => 2
            ],
            [
                'teamsAmount' => 4,
                'matchesCount' => 4
            ]
        ];
    }
}
