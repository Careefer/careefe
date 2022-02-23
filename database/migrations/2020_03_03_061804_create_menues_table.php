<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('permission_name');
            $table->integer('parent')->default(0);
            $table->string('url');
            $table->enum('status',['active','inactive']);
            $table->integer('sort');
            $table->string('class',20);
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
        Schema::drop('menues');
    }
}
