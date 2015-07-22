<?php





require __DIR__.'/../../bootstrap/autoload.php';

$app = require_once __DIR__.'/../../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use \App;

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$tournament = App\Models\Tournament::find(1);

App\Models\Match::where(['tournamentId' => $tournament->id])->delete();

$event = new App\Events\TournamentWasStarted($tournament);

$handler = new App\Listeners\Tournament\DrawLeague;
$handler->handle($event);