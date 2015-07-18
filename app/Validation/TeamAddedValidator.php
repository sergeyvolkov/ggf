<?php

namespace App\Validation;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class TeamAddedValidator extends Validator
{
    public function validateTeamAdded($attribute, $value, $parameters)
    {
        Log::info($value);

        return false;
    }
}