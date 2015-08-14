<?php

namespace App\Models;

use Illuminate\Database\Eloquent;

class Model extends Eloquent\Model
{
    public static function getTableName()
    {
        return ((new self)->getTable());
    }
}