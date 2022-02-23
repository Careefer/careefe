<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRecentJobSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recent_job_search', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->comment='if user logged in';
            $table->string('ip',50);
            $table->string('string',255);
            $table->integer('total_result')->comment='Number of listed result';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recent_job_search');
    }
}
