<?php

namespace App\Tests\Functional\Http\API;

use App\Models\Match;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Events\TournamentWasStarted;

use App\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class MatchTest extends TestCase
{
//    use DatabaseMigrations, DatabaseTransactions;

    public function testCorrectResponseOnCatalogueAction()
    {
        $this->call('get', '/api/v1/matches');

        $this->assertResponseOk();
    }

    /**
     * @param $request
     * @param $response
     * @param $attributesToCheck
     *
     * @dataProvider matchUpdatesWithRequests
     */
    public function testUpdateMatchScore($request, $response, $attributesToCheck)
    {
        /**
         * @var $tournament Tournament
         * @var $league League
         * @var $homeTeam Team
         * @var $awayTeam Team
         * @var $homeTournamentTeam TournamentTeam
         * @var $awayTournamentTeam TournamentTeam
         * @var $match Match
         */
        $tournament = Factory::create('App\Models\Tournament');
        $league = Factory::create('App\Models\League');

        $homeTeam = Factory::create('App\Models\Team', [
            'leagueId' => $league->id
        ]);

        $awayTeam = Factory::create('App\Models\Team', [
            'leagueId' => $league->id
        ]);

        $homeTournamentTeam = Factory::create('App\Models\TournamentTeam', [
            'teamId' => $homeTeam->id,
            'tournamentId' => $tournament->id
        ]);

        $awayTournamentTeam = Factory::create('App\Models\TournamentTeam', [
            'teamId' => $awayTeam->id,
            'tournamentId' => $tournament->id
        ]);

        $match = Factory::create('App\Models\Match', [
            'tournamentId' => $tournament->id,
            'homeTournamentTeamId' => $homeTournamentTeam->id,
            'awayTournamentTeamId' => $awayTournamentTeam->id
        ]);

        $this->put(
            '/api/v1/matches/' . $match->id,
            [
                'match' => array_merge(['id' => $match->id], $request)
            ],
            [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'HTTP_CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $this->assertResponseStatus($response['status']);

        if (!empty($result)) {
            $updatedRow = Match::find($match->id);

            foreach ($result as $property => $value) {
                $this->assertEquals($value, $updatedRow->getAttribute($property));
            }
        }
    }

    public function matchUpdatesWithRequests()
    {
        return [
            'successMatchUpdate' => [
                'request' => [
                    'homeScore' => 4,
                    'awayScore' => 2,
                    'status' => Match::STATUS_FINISHED
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => []
            ],
            'successMatchUpdateWithHomeWinResultType' => [
                'request' => [
                    'homeScore' => 4,
                    'awayScore' => 2,
                    'status' => Match::STATUS_FINISHED
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => [
                    'resultType' => Match::RESULT_TYPE_HOME_WIN
                ]
            ],
            'successMatchUpdateWithAwayWinResultType' => [
                'request' => [
                    'homeScore' => 2,
                    'awayScore' => 4,
                    'status' => Match::STATUS_FINISHED
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => [
                    'resultType' => Match::RESULT_TYPE_AWAY_WIN
                ]
            ],
            'successMatchUpdateWithDrawResultType' => [
                'request' => [
                    'homeScore' => 2,
                    'awayScore' => 2,
                    'status' => Match::STATUS_FINISHED
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => [
                    'resultType' => Match::RESULT_TYPE_DRAW
                ]
            ],
            'invalidStatusProperty' => [
                'request' => [
                    'homeScore' => 0,
                    'awayScore' => 0,
                    'status' => 'invalid_string'
                ],
                'response' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                ],
                'attributesToCheck' => []
            ],
            'missedProperties' => [
                'request' => [],
                'response' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                ],
                'attributesToCheck' => []
            ]
        ];
    }

}
