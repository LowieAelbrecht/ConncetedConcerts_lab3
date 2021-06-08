<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Userbingo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userbingo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('bingo_id');
            $table->integer('concert_id');
            $table->boolean('received')->default(false); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
