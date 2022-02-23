<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employer_id')->comment="employer display uniqu id";
            $table->string('company_name')->nullable();
            $table->string('slug',255);
            $table->string('logo',50)->default('default.png');
            $table->integer('head_office_location_id')->nullable();
            $table->integer('industry_id')->nullable();
            $table->string('size_of_company',20)->nullable();
            $table->string('website_url',255)->nullable();
            $table->text('about_company')->nullable();
            $table->enum('is_featured',['no','yes']);
            $table->integer('total_active_jobs')->nullable();
            $table->enum('status',['active','inactive']);
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
        Schema::dropIfExists('employer_detail');
    }
}
