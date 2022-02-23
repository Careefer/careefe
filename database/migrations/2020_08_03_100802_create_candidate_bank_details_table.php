<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_format_id');
            $table->unsignedBigInteger('bank_format_field_id');
            $table->string('name',255)->nullable();
            $table->string('value',255)->nullable(); 
            $table->string('label',255)->nullable();    
            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('country_id');
            // $table->foreign('bank_format_field_id')
            //         ->references('id')
            //         ->on('bank_format_fields')
            //         ->constrained()
            //         ->onDelete('cascade');
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
        Schema::dropIfExists('candidate_bank_details');
    }
}
