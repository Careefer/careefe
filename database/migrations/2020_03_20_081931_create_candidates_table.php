<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('candidate_id',50)->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->comment="Personal Email";
            $table->string('phone',15)->nullable();
            $table->string('password')->nullable();
            $table->string('image',100)->nullable();
            $table->string('official_email',100)->nullable();
            $table->text('profile_summary')->nullable();
            $table->string('timezone',100)->nullable();
            $table->string('currency',20)->nullable();
            $table->string('skill_ids',255)->nullable();
            $table->string('resume',50)->nullable();
            $table->string('cover_letter',50)->nullable();
            $table->enum('status',['active','inactive'])->nullable();
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
        Schema::drop('candidates');
    }
}
