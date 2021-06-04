<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongvoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songvote', function (Blueprint $table) {
            $table->increments('id');
            $table->string('song');
            $table->integer('votes');
            $table->integer('concert_id');
            $table->integer('artist_id');  
            $table->date('ending_date'); 
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
        Schema::dropIfExists('songvote');
    }
}
