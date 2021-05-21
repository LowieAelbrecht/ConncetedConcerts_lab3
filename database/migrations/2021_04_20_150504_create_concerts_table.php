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
            $table->integer('artist_id')->nullable();
            //$table->integer('userID')->nullable(); zal apparte kolom worden dat userid en concerid samenbrengt
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
