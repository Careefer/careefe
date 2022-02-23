<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferJobLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refer_job_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('refer_by_id')->comment="candidate id";
            $table->foreign('refer_by_id')
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
            $table->string('friend_email',100);
            $table->text('job_url');
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
        Schema::dropIfExists('refer_job_log');
    }
}
