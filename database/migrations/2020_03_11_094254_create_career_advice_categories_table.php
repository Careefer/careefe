<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerAdviceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_advice_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('title', 255)->nullable();
            $table->string('slug');
            $table->enum('status', ['active','inactive'])->nullable();
            $table->enum('is_recommend', ['yes','no'])->nullable();
            $table->string('meta_title',255)->nullable();
            $table->string('meta_keyword',255)->nullable();
            $table->text('meta_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career_advice_categories');
    }
}
