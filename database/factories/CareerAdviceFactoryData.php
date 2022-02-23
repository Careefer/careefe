<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CareerAdvice;
use Faker\Generator as Faker;

$factory->define(CareerAdvice::class, function (Faker $faker)
{
	    $image_arr = array('1588253970.jpeg','1588320868.jpeg','1588321986.jpeg','1588322071.jpeg','1588240585.png','1588240441.jpeg');
	    return [
	        'category_id'=> $faker->randomElement(array(1,2,3,4,5,6,7,8,9,10,11,12)),
	        'title'		 => $faker->sentence(8,true),
	        'slug'		 => $faker->slug,
	        'image'  	=> $faker->randomElement($image_arr),
	        'type'		=> 'image',
	        'content'	=> $faker->paragraph(50),
	        'status'	=> 'active',
	        'meta_title'	=> $faker->sentence(5),
	        'meta_keyword'	=> $faker->sentence(5),
	        'meta_desc'	=> $faker->text,
	        'created_at'	=> $faker->dateTime
	    ];
});
