<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employer_branch_office;
use Faker\Generator as Faker;

$factory->define(Employer_branch_office::class, function (Faker $faker) {
    return [
        'employer_id' => DB::table('employer_detail')->select('id')->inRandomOrder()->value('id'),
        'location_id' => DB::table('world_location')->where(['country_id'=>'101'])->whereNotNull(['state_id','city_id'])->select('id')->inRandomOrder()->value('id'),
    ];
});

/*$factory->create(App\User::class)->id,*/