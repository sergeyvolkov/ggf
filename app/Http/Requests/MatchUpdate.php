<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Match;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        return [
            'match.homeScore' => 'required|integer',
            'match.awayScore' => 'required|integer',
            'match.status' => 'required|in:' . join(',', Match::getAvailableStatuses())
        ];
    }
}
