<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('cities', function (Blueprint $table){
            $table->increments('id')->index();
            $table->string('name');
            $table->integer('country_id');
            $table->integer('state_id');
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
        Schema::dropIfExists('cities');
    }
}
