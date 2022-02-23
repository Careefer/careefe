<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('specialist_id', 20);
            $table->string('name', 100)->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('official_email', 100)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('skill_ids',255)->nullable();
            $table->text('profile_summary')->nullable();
            $table->string('password', 100);
            $table->integer('functional_area_ids')->nullable();
			$table->string('resume',100)->nullable();
            $table->enum('status',['active','inactive']);
            $table->rememberToken();
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
        Schema::drop('specialists');
    }
}
