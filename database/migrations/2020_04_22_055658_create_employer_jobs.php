<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id',50);
            $table->integer('specialist_id')->nullable();
            $table->integer('employer_id')->comment="company user'id";
            $table->integer('company_id')->comment="employer_detail table id";
            $table->integer('position_id')->comment="Designation id";
            $table->float('experience_min', 4, 1);  
            $table->float('experience_max', 4, 1);
            $table->integer('vacancy');
            $table->string('skill_ids');
            $table->float('salary_min', 8, 1);
            $table->float('salary_max', 8, 1);
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->string('functional_area_ids');
            $table->string('education_ids');
            $table->integer('work_type_id');
            $table->enum('commission_type',['percentage', 'amount']);
            $table->float('commission_amt', 8, 2)->comment="percentage or fixed amount";
            $table->integer('country_id');
            $table->text('state_ids')->nullable();
            $table->text('city_ids')->nullable();
            $table->float('referral_bonus_amt', 8, 2)->nullable();
            $table->integer('job_nature_id')->nullable();
            $table->text('slug');
            $table->enum('status',['pending','active','on_hold','closed','cancelled'])->default('pending');
            $table->integer('total_views')->nullable();
            $table->integer('no_of_applications')->nullable();
            $table->integer('no_of_referrals')->nullable();
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
        Schema::dropIfExists('employer_jobs');
    }
}
