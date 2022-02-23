<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')
                    ->references('id')
                    ->on('job_applications')
                    ->constrained()
                    ->onDelete('cascade');
            $table->enum('user_type',['specialist','candidate','admin'])->default('candidate');
            $table->foreign('employer_id')
                    ->references('id')
                    ->on('employers')
                    ->constrained()
                    ->onDelete('cascade');
            $table->string('amount',255)->nullable();
            $table->tinyInteger('is_paid')->nullable()->comment('1=>paid | 0=>unpaid');
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
        Schema::dropIfExists('payment_history');
    }
}
