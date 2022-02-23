<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Spatie\Permission\Models\Role::class, function (Faker $faker) {
    return [
        'name'          =>  $faker->name,
        'guard_name'    =>  'admin',
        'description'   =>  $faker->text,
        'status'        =>  $faker->randomElement(['active','inactive']),
        'created_at'    =>  $faker->dateTime($max = 'now')
    ];
});
