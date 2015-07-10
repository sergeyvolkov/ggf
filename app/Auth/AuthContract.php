<?php

namespace App\Auth;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate;

interface AuthContract extends Illuminate\Contracts\Auth\Guard
{

}
