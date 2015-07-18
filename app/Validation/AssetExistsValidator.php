<?php

namespace App\Validation;

use Illuminate\Validation\Validator;

class AssetExistsValidator extends Validator
{
    public function validateAssetExists($attribute, $value, $parameters)
    {
        return realpath(public_path() . DIRECTORY_SEPARATOR . $value);
    }
}