<?php

$factory('App\Models\Tournament', [
    'name' => $faker->name,
    'owner' => 'factory:App\Models\Member',
    'description' => $faker->text(50)
]);