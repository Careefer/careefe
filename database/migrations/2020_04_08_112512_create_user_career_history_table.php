<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCareerHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_career_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->enum('user_type',['candidate','employer','specialist']);
            $table->string('company_name')->nullable();
            $table->integer('designation_id')->nullable();            
            $table->integer('location_id')->nullable();
            $table->string('job_skill_ids')->nullable();
            $table->text('roles_responsibilities')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('is_current_company',['yes','no'])->nullable();
            $table->text('key_achievements')->nullable();
            $table->text('additional_information')->nullable();
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
        Schema::dropIfExists('career_history');
    }
}
