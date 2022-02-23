<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFavoriteJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favorite_job', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('candidate_id');
            $table->foreign('candidate_id')
                        ->references('id')
                        ->on('candidates')
                        ->constrained()
                        ->onDelete('cascade');
            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')
                        ->references('id')
                        ->on('employer_jobs')
                        ->constrained()
                        ->onDelete('cascade');
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
        Schema::dropIfExists('user_favorite_job');
    }
}
