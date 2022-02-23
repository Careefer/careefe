<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EmployerDetail;
use Faker\Generator as Faker;

$factory->define(EmployerDetail::class, function (Faker $faker)
{	
	$image_arr = ['ae.png','amazon.png','apache.png','google.png','intel.png','project-apache.png','airtel.png','amazon-logo.jpg','hello.jpg','project-ae.png','samsung.png','alltel.png','amiga.png','expedia-logo.jpg','img-apache.png','project-alltel.png','trivago-logo.png'];
    return [
        'employer_id' => 'EMP-'.$faker->randomDigit,
        'company_name' => $faker->company,
        'slug'			=> $faker->slug,
        'logo'			=> $faker->randomElement($image_arr),
        'head_office_location_id'=>'57584',
        'industry_id'	=> $faker->randomElement(array(1,4,3,5)),
        'size_of_company' => $faker->randomElement(array('0-100','100-200','200+')),
        'website_url' => 'https://www.google.co.in/',
        'about_company' => $faker->text(400),
        'is_featured'	=> $faker->randomElement(['yes','no']),
        'status'		=> 'active'
    ];
});
