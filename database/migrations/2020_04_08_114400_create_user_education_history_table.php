<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->enum('user_type',['candidate','employer','specialist']);
            $table->string('qualification',50)->nullable();
            $table->string('course',50)->nullable();
            $table->string('institute')->nullable();
            $table->string('degree')->nullable()->comment="Stream (Degree Specialization)";
            $table->enum('grade',['gpa','percentage'])->nullable();
            $table->string('grade_data',50)->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('specialization',255)->nullable()->comment="Stream/Specialization";
            $table->enum('currently_pursuing',['yes','no'])->nullable();
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
        Schema::dropIfExists('user_education_history');
    }
}
