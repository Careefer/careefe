<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_format_id');
            $table->unsignedBigInteger('bank_format_field_id');
            $table->string('name',255)->nullable();
            $table->string('value',255)->nullable(); 
            $table->string('label',255)->nullable();    
            $table->unsignedBigInteger('specialist_id');
            $table->unsignedBigInteger('country_id');
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
        Schema::dropIfExists('specialist_bank_details');
    }
}
