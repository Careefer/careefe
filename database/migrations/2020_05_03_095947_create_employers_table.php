<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('employer_detail')
                                        ->constrained()
                                        ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('mobile',20)->nullable();
            $table->string('password');
            $table->integer('location_id')->nullable()->comment='world location id';
            $table->integer('time_zone_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->enum('status',['active','inactive']);
            $table->rememberToken();
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
        Schema::dropIfExists('employers');
    }
}
