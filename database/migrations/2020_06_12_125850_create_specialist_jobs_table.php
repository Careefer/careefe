<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')
                    ->references('id')
                    ->on('employer_jobs')
                    ->constrained()
                    ->onDelete('cascade');

            $table->unsignedInteger('primary_specialist_id');
            $table->foreign('primary_specialist_id')
                        ->references('id')
                        ->on('specialists')
                        ->constrained()
                        ->onDelete('cascade');
            
            $table->unsignedInteger('secondary_specialist_id')->nullable();
            $table->foreign('secondary_specialist_id')
                        ->references('id')
                        ->on('specialists')
                        ->constrained()
                        ->onDelete('cascade');

            $table->enum('status',['pending','accept','decline'])->default('pending');
            
            $table->enum('is_current_specialist',['yes','no'])->nullable();            
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
        Schema::dropIfExists('specialist_jobs');
    }
}
