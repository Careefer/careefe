<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_types', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('status',['active','inactive']);
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
        Schema::dropIfExists('work_type');
    }
}
