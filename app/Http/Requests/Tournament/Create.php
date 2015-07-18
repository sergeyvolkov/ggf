<?php

namespace App\Http\Requests\Tournament;

use App\Http\Requests\Request;
use App\Models\Tournament;

class Create extends Request
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
            'tournament.name' => 'required',
            'tournament.description' => '',
            'tournament.type' => 'in:' . join(',', Tournament::getAvailableTypes()),
            'tournament.membersType' => 'in:' . join(',', Tournament::getAvailableMembersType())
        ];
    }
}
