<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerAdvicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_advices', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('category_id');
            $table->string('title');
            $table->string('slug');
            $table->string('image',100);
            $table->enum('type',['video','image']);
            $table->binary('content');
            $table->enum('status',['active','inactive']);
            $table->string('meta_title',255)->nullable();
            $table->string('meta_keyword',255)->nullable();
            $table->text('meta_desc')->nullable();
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
        Schema::dropIfExists('career_advices');
    }
}
