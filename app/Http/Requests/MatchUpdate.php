<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Match;

class MatchUpdate extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'match.id' => 'required|integer',
            'match.homeScore' => 'required|integer',
            'match.awayScore' => 'required|integer',
            'match.status' => 'required|in:' . join(',', Match::getAvailableStatuses())
        ];
    }
}
