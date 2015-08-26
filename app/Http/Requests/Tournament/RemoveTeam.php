<?php

namespace App\Http\Requests\Tournament;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class RemoveTeam extends Request
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
