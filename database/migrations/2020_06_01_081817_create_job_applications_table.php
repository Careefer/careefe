<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')
                    ->references('id')
                    ->on('employer_jobs')
                    ->constrained()
                    ->onDelete('cascade');                  

            $table->unsignedInteger('candidate_id');
            $table->foreign('candidate_id')
                        ->references('id')
                        ->on('candidates')
                        ->constrained()
                        ->onDelete('cascade');

            $table->string('application_id',20);           
                                                        
            $table->string('name',100);
            $table->string('email',100);               
            $table->string('mobile',20);               
            $table->string('current_company',100)->nullable();        
            $table->string('resume',50)->nullable();               
            $table->string('cover_letter',50)->nullable();               
            $table->unsignedInteger('refer_by')->nullable()->comment="candidate id";
            $table->foreign('refer_by')
                    ->references('id')
                    ->on('candidates')
                    ->constrained()
                    ->onDelete('SET NULL');
            $table->unsignedInteger('applied_by')->nullable()->comment="candidate id";
            $table->foreign('applied_by')
                    ->references('id')
                    ->on('candidates')
                    ->constrained()
                    ->onDelete('SET NULL');
            $table->tinyInteger('rating_by_specialist')->nullable();
            $table->tinyInteger('rating_by_employer')->nullable();
            $table->tinyInteger('rating_by_referee')->nullable();
            $table->text('specialist_notes')->nullable();
            $table->text('employer_notes')->nullable()->comment="company notes";
            $table->enum('status',['applied','in_progress','unsuccess','success','candidate_declined','hired','cancelled'])->default('applied');
            $table->unsignedInteger('recommended_by')->nullable()->after('status')->comment="specialist id";
            $table->foreign('recommended_by')
                    ->references('id')
                    ->on('specialists')
                    ->constrained()
                    ->onDelete('SET NULL');
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
        Schema::dropIfExists('job_applications');
    }
}
