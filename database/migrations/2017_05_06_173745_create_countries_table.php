<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table)
        {
           $table->increments('id')->index();
           $table->string('code')->nullable();
           $table->string('name');
           $table->integer('timezone_id');
           $table->integer('phonecode')->nullable();
           $table->enum('status',['active','inactive']);
           $table->timestamps();
           $table->softdeletes();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
