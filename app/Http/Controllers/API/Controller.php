<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Sorskod\Larasponse\Larasponse;

abstract class Controller extends Controllers\Controller
{
    protected $response;

    public function __construct(Larasponse $response)
    {
        $this->response = $response;

        // The Fractal parseIncludes() is available to use here
//        $this->response->parseIncludes(Input::get('includes'));
    }
}
