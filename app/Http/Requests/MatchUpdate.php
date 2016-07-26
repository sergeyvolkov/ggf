<?php

namespace App\Http\Requests;

use App\Events\MatchWasFinished;
use App\Http\Requests\Request;
use App\Listeners\Match\UpdateResultType;
use App\Models\Match;
use App\Models\Tournament;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MatchUpdate extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $matchId = $this->route('matchId');

        /**
         * Copy of match row
         *
         * @var $match Match
         */
        $match = Match::find($matchId)->replicate();
        $tournament = $match->tournament()->get()->first();

        Validator::extend('round_active', function($attribute, $value, $parameters) use ($match, $tournament) {
            return $this->isRoundActive($match, $tournament);
        });

        Validator::extend('round_finished_for_pair', function($attribute, $value, $parameters) use ($match, $tournament) {
            $match->status = $value;
            return $this->isRoundFinishedForPair($match, $tournament);
        });

        return [
            'match.homeScore' => 'required|integer',
            'match.awayScore' => 'required|integer',
            'match.status' => 'required|in:' . join(',', Match::getAvailableStatuses()) . '|round_active|round_finished_for_pair'
        ];
    }

    protected function isRoundActive($match, $tournament) {

        // rule is not applied for Leagues
        if (Tournament::TYPE_LEAGUE === $tournament->type) {
            return true;
        }

        // rule is not applied for group stage matches
        if (Match::GAME_TYPE_GROUP_STAGE === $match->gameType) {
            return true;
        }

        return $match->round === $tournament->getCurrentRound();
    }

    /**
     * @param $match
     * @param $tournament Tournament
     * @return bool
     */
    protected function isRoundFinishedForPair($match, $tournament)
    {
        // rule is not applied for Leagues
        if (Tournament::TYPE_LEAGUE === $tournament->type) {
            return true;
        }

        // rule is not applied for group stage matches
        if (Match::GAME_TYPE_GROUP_STAGE === $match->gameType) {
            return true;
        }

        $match->fill(array_get($this->only(['match.homeScore', 'match.awayScore', 'match.status']), 'match'));

        $event = new MatchWasFinished($match);

        $listener = new UpdateResultType();
        $listener->handle($event);

        $secondMatchForPair = Match::where([
            'round' => $match->round,
            'homeTournamentTeamId' => $match->awayTournamentTeamId,
            'awayTournamentTeamId' => $match->homeTournamentTeamId
        ])->first();

        $matches = new Collection([$event->match, $secondMatchForPair]);

        // all matches in pair should have `finished` status
        if ($matches->where('status', Match::STATUS_FINISHED)->count() < 2) {
            return true;
        }

        $score = $tournament->getScore($matches);

        return 2 === $score->unique('position')->count();
    }
}
