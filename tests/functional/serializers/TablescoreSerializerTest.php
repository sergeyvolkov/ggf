<?php

namespace App\Tests\Functional\Events;

use App\Models\League;
use App\Models\Match;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;

use App\Serializers\Tournament\TablescoreSerializer;
use App\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laracasts\TestDummy\Factory;
use Illuminate\Support\Debug\Dumper;

class TablescoreSerializerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @param $teams
     * @param $matches
     * @param $resultTablescore
     *
     * @dataProvider matchesProvider
     */
    public function testSerializerWithMatchesList($teams, $matches, $resultTablescore)
    {
        /**
         * @var $tournament Tournament
         */
        $tournament = Factory::create(Tournament::class);
        $league = Factory::create(League::class);

        for ($i = 1; $i <= $teams; $i++) {
            TournamentTeam::forceCreate([
                'id' => $i,
                'tournamentId' => $tournament->id,
                'teamId' => array_get(Factory::create(Team::class, ['leagueId' => $league->id]), 'id')
            ]);
        }

        foreach($matches as $key => $match) {
            Match::create([
                'tournamentId' => $tournament->id,
                'homeTournamentTeamId' => $match['homeTeamId'],
                'awayTournamentTeamId' => $match['awayTeamId'],
                'homeScore' => $match['homeScore'],
                'awayScore' => $match['awayScore'],
                'homePenaltyScore' => 0,
                'awayPenaltyScore' => 0,
                'resultType' => $match['resultType'],
                'gameType' => Match::GAME_TYPE_GROUP_STAGE,
                'status' => Match::STATUS_FINISHED,
                'round' => $key
            ]);
        }

        $serializer = new TablescoreSerializer();

        $collection = $serializer->collection(Match::where(['tournamentId' => $tournament->id])->get());

        foreach ($resultTablescore as $teamScore) {
            $item = $collection->first(function($key, $item) use ($teamScore) {
                return $item['teamId'] == $teamScore['team'];
            });

            $this->assertEquals($item['position'], $teamScore['position']);
        }
    }

    public function matchesProvider()
    {
        return [
            'twoTeamsWithDifferentPoints' => [
                'teams' => 2,
                'matches' => [
                    [
                        'homeTeamId' => 1,
                        'awayTeamId' => 2,
                        'homeScore' => 2,
                        'awayScore' => 0,
                        'resultType' => 'home'
                    ],
                    [
                        'homeTeamId' => 2,
                        'awayTeamId' => 1,
                        'homeScore' => 0,
                        'awayScore' => 0,
                        'resultType' => 'draw'
                    ]
                ],
                'resultTablescore' => [
                    ['team' => 1, 'position' => 1],
                    ['team' => 2, 'position' => 2]
                ]
            ],
            'twoTeamsWithEqualPointsAndGoalDifferenceAndGoalsScored' => [
                'teams' => 3,
                'matches' => [
                    [
                        'homeTeamId' => 1,
                        'awayTeamId' => 2,
                        'homeScore' => 2,
                        'awayScore' => 0,
                        'resultType' => 'home'
                    ],
                    [
                        'homeTeamId' => 2,
                        'awayTeamId' => 3,
                        'homeScore' => 0,
                        'awayScore' => 2,
                        'resultType' => 'away'
                    ]
                ],
                'resultTablescore' => [
                    ['team' => 1, 'position' => 1],
                    ['team' => 3, 'position' => 1],
                    ['team' => 2, 'position' => 3],
                ]
            ],
            'twoTeamsWithEqualPointsAndGoalDifferenceButDifferentGoalsScored' => [
                'teams' => 3,
                'matches' => [
                    [
                        'homeTeamId' => 1,
                        'awayTeamId' => 2,
                        'homeScore' => 2,
                        'awayScore' => 0,
                        'resultType' => 'home'
                    ],
                    [
                        'homeTeamId' => 2,
                        'awayTeamId' => 3,
                        'homeScore' => 1,
                        'awayScore' => 3,
                        'resultType' => 'away'
                    ]
                ],
                'resultTablescore' => [
                    ['team' => 1, 'position' => 1],
                    ['team' => 3, 'position' => 2],
                    ['team' => 2, 'position' => 3],
                ]
            ]
        ];
    }
}
