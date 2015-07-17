<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

use App\Validation\AssetExistsValidator;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {


        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages) {
            return new AssetExistsValidator($translator, $data, $rules, $messages);
        });
    }

    public function register()
    {
        //
    }
}
