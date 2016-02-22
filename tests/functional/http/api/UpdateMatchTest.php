<?php

namespace App\Tests\Functional\Http\API;

use App\Models\Match;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Events\TournamentWasStarted;

use App\Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Laracasts\TestDummy\Factory;

class UpdateMatchTest extends TestCase
{
    /**
     * @param $request
     * @param $response
     * @param $attributesToCheck
     *
     * @dataProvider matchesScore
     */
    public function testUpdateMatchScore($request, $response, $attributesToCheck)
    {
        $member = Factory::create('App\Models\Member');

        Auth::login($member);

        /**
         * @var $tournament Tournament
         * @var $league League
         * @var $homeTeam Team
         * @var $awayTeam Team
         * @var $homeTournamentTeam TournamentTeam
         * @var $awayTournamentTeam TournamentTeam
         * @var $match Match
         */
        $tournament = Factory::create(
            'App\Models\Tournament',
            array_get($request, 'tournament', [])
        );
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
                'match' => array_get($request, 'match', [])
            ],
            [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'HTTP_CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $this->assertResponseStatus($response['status']);

        if (!empty($attributesToCheck)) {
            /**
             * @var $updatedRow Match
             */
            $updatedRow = Match::find($match->id);

            foreach ($attributesToCheck as $attribute => $value) {
                $this->assertEquals($value, $updatedRow->getAttribute($attribute));
            }
        }
    }

    public function matchesScore()
    {
        return [
            'successMatchUpdate' => [
                'request' => [
                    'match' => [
                        'homeScore' => 4,
                        'awayScore' => 2,
                        'status' => Match::STATUS_FINISHED
                    ]
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => []
            ],
            'successMatchUpdateWithNotStartedStatus' => [
                'request' => [
                    'match' => [
                        'homeScore' => 2,
                        'awayScore' => 2,
                        'status' => Match::STATUS_NOT_STARTED
                    ]
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => [
                    'homeScore' => 2,
                    'awayScore' => 2,
                    'status' => Match::STATUS_NOT_STARTED,
                    'resultType' => Match::RESULT_TYPE_DRAW
                ]
            ],
            'successMatchUpdateWithStartedStatus' => [
                'request' => [
                    'match' => [
                        'homeScore' => 1,
                        'awayScore' => 1,
                        'status' => Match::STATUS_STARTED
                    ]
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => [
                    'homeScore' => 1,
                    'awayScore' => 1,
                    'status' => Match::STATUS_STARTED,
                    'resultType' => Match::RESULT_TYPE_DRAW
                ]
            ],
            'successMatchUpdateWithHomeWinResultType' => [
                'request' => [
                    'match' => [
                        'homeScore' => 4,
                        'awayScore' => 2,
                        'status' => Match::STATUS_FINISHED
                    ]
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
                    'match' => [
                        'homeScore' => 2,
                        'awayScore' => 4,
                        'status' => Match::STATUS_FINISHED
                    ]
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
                    'match' => [
                        'homeScore' => 2,
                        'awayScore' => 2,
                        'status' => Match::STATUS_FINISHED
                    ]
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
                    'match' => [
                        'homeScore' => 0,
                        'awayScore' => 0,
                        'status' => 'invalid_string'
                    ]
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
            ],
            'successMatchUpdateForLeagueTournamentType' => [
                'request' => [
                    'tournament' => [
                        'type' => Tournament::TYPE_LEAGUE
                    ],
                    'match' => [
                        'round' => 1,
                        'homeScore' => 0,
                        'awayScore' => 2,
                        'status' => Match::STATUS_FINISHED
                    ]
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => []
            ],
            'successMatchUpdateForKnockOutTournamentType' => [
                'request' => [
                    'tournament' => [
                        'type' => Tournament::TYPE_KNOCK_OUT
                    ],
                    'match' => [
                        'round' => 1,
                        'homeScore' => 2,
                        'awayScore' => 1,
                        'status' => Match::STATUS_FINISHED
                    ]
                ],
                'response' => [
                    'status' => Response::HTTP_OK
                ],
                'attributesToCheck' => []
            ],
        ];
    }

    public function testFailedMatchScoreUpdateByGuest()
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
                'match' => [
                    'homeScore' => 1,
                    'awayScore' => 2,
                    'status' => Match::STATUS_FINISHED
                ]
            ],
            [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'HTTP_CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
        $this->assertEquals(Match::find($match->id)->status, Match::STATUS_NOT_STARTED);
    }

    public function testMatchUpdateFailForUpdateOldRoundOfKnockOutTournamentType()
    {
        $member = Factory::create('App\Models\Member');

        Auth::login($member);

        /**
         * @var $tournament Tournament
         * @var $league League
         */
        $tournament = Factory::create(
            'App\Models\Tournament',
            [
                'type' => Tournament::TYPE_KNOCK_OUT
            ]
        );
        $league = Factory::create('App\Models\League');

        Factory::times(4)->create('App\Models\Team', ['leagueId' => $league->id])
            ->each(function($team, $key) use ($tournament) {
                $tournament->tournamentTeams()->create([
                    'teamId' => $team->id,
                    'tournamentId' => $tournament->id,
                ]);
            });

        $tournament->status = Tournament::STATUS_STARTED;
        $tournament->save();

        $this->assertEquals($tournament->matches->count(), 4);

        // update results of first round matches
        foreach ($tournament->matches as $match) {
            /**
             * @var Match $match
             */

            // set first team as winner
            if ($match->homeTournamentTeamId > $match->awayTournamentTeamId) {
                $match->homeScore = 1;
                $match->awayScore = 0;
            } else {
                $match->homeScore = 0;
                $match->awayScore = 1;
            }

            $match->status = Match::STATUS_FINISHED;
            $match->save();
        }

        // next round matches should be generated
        $this->assertEquals($tournament->getCurrentRound(), 2);

        // get finished match from previous round
        $oldRoundMatch = $tournament->matches()->where(['round' => 1])->get()->first();

        $this->assertInstanceOf(Match::class, $oldRoundMatch);

        $this->put(
            '/api/v1/matches/' . $oldRoundMatch->id,
            [
                'match' => [
                    'homeScore' => 1,
                    'awayScore' => 2,
                    'status' => Match::STATUS_FINISHED
                ]
            ],
            [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'HTTP_CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
