<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'client_name' => $faker->name,
        'address1' => $faker->address,
        'address2' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'phone_no1' => '123-456-7890',
        'phone_no2' => '123-456-7891',
        'zip' => $faker->postcode,
        'start_validity' => today(),
        'end_validity' => today()->addDays(15),
        'status' => Client::STATUS_INACTIVE
    ];
});
