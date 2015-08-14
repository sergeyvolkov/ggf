<?php

namespace App\Http\Requests\Team;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class RemoveTeamMember extends Request
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
        return [];
    }
}
