<?php

$factory(\App\Models\Member::class, [
    'name' => $faker->name,
    'facebookId' => $faker->randomNumber(6)
]);