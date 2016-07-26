<?php

namespace App\Validation;

class AssetExistsValidator
{
    public function validate($attribute, $value, $parameters)
    {
        return realpath(public_path() . DIRECTORY_SEPARATOR . $value);
    }
}