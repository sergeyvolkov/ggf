<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Match;
use App\Models\Tournament;
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
        Validator::extend('match_round_active', function($attribute, $value, $parameters) {
            $matchId = $this->route('matchId');

            $match = Match::find($matchId);
            $tournament = $match->tournament()->get()->first();

            // rule is not applied for Leagues
            if (Tournament::TYPE_LEAGUE === $tournament->type) {
                return true;
            }

            // rule is not applied for group stage matches
            if (Match::GAME_TYPE_GROUP_STAGE === $match->gameType) {
                return true;
            }

            return $match->round === $tournament->getCurrentRound();
        });

        return [
            'match.homeScore' => 'required|integer',
            'match.awayScore' => 'required|integer',
            'match.status' => 'required|in:' . join(',', Match::getAvailableStatuses()) . '|match_round_active'
        ];
    }
}
