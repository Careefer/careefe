<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJobAlerts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_job_alerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email',100);
            $table->string('ip',50);
            $table->unsignedInteger('candidate_id')->nullable();
            $table->foreign('candidate_id')
                        ->references('id')
                        ->on('candidates')
                        ->constrained()
                        ->onDelete('cascade');
            $table->string('keyword')->nullable();   
            $table->string('functional_area_ids')->nullable();
            $table->integer('country_id');   
            $table->string('state_ids')->nullable();   
            $table->string('city_ids')->nullable();   
            $table->string('work_type_ids')->nullable();   
            $table->float('referral_bonus_from',8,2)->nullable();
            $table->float('referral_bonus_to',8,2)->nullable();
            $table->float('salary_from',10,2)->nullable();
            $table->float('salary_to',10,2)->nullable();
            $table->string('position_ids')->nullable();
            $table->float('experience_from',4,1)->nullable();   
            $table->float('experience_to',4,1)->nullable();
            $table->string('skill_ids')->nullable();
            $table->string('education_ids')->nullable();
            $table->string('industry_ids')->nullable();
            $table->string('company_ids')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_job_alerts');
    }
}
