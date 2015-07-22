<?php

passthru("php artisan migrate:reset --force");
passthru("php artisan migrate --force");

require __DIR__ . '/../../bootstrap/autoload.php';