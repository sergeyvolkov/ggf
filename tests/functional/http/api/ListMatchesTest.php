<?php

namespace App\Tests\Functional\Http\API;

use App\Tests\TestCase;

class ListMatchesTest extends TestCase
{
    public function testCorrectResponseOnCatalogueAction()
    {
        $this->call('get', '/api/v1/matches');

        $this->assertResponseOk();
    }
}
