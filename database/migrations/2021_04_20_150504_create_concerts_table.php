<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('artist_name');
            $table->string('locatie');
            $table->dateTime('concert_date');
            $table->double('prijs', 15, 2);
            $table->string('file_path');
            $table->string('tm_id');
            $table->boolean('published')->default(false);
            $table->double('tickets_sold')->default(0);
            $table->integer('artist_id')->nullable();            
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
        Schema::dropIfExists('concerts');
    }
}
