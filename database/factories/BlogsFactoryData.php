<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {

	$image_arr = array('1584534803.jpeg','1588147512.jpeg','1588240441.jpeg','1588240585.png','1588248869.jpeg','1588231094.jpeg');
    return [
        'category_id'=> $faker->randomElement(array(2,3,4,5,6,7,8,9)),
        'title'		 => $faker->sentence(8,true),
        'slug'		 => $faker->slug,
        'image'  	=> $faker->randomElement($image_arr),
        'type'		=> 'image',
        'content'	=> $faker->paragraph(8),
        'status'	=> 'active',
        'meta_title'	=> $faker->sentence(5),
        'meta_keyword'	=> $faker->sentence(5),
        'meta_desc'	=> $faker->text,
        'created_at'	=> $faker->dateTime
    ];
});
