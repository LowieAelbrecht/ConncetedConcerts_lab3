<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBingoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bingo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_name');
            $table->integer('item_amount');
            $table->string('item_info');
            $table->string('file_path');
            $table->integer('concert_id'); 
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
        Schema::dropIfExists('bingo');
    }
}
