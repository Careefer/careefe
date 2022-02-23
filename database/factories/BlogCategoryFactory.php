<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;


$factory->define(\App\Models\BlogCategory::class, function (Faker $faker) {
    return [
        'title' 	  => $faker->name,
        'slug'  	  => $faker->slug,
        'status' 	  => 'active',
        'meta_title'  => $faker->sentence,
        'meta_keyword'=> $faker->paragraph,
        'meta_desc'   => $faker->sentence,
    ];
});
