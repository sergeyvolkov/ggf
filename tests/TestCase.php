<?php

namespace App\Tests;

use Faker;
use Illuminate\Foundation;
use Illuminate\Contracts\Console\Kernel;

class TestCase extends Foundation\Testing\TestCase
{
    /**
     * @var Faker\Generator
     */
    protected $faker;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}
