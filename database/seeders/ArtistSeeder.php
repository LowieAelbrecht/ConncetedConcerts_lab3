<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artist = new \App\Models\Artist();
        $artist->name = "Sophie";
        $artist->bio = "Lorem ipsum";
        $artist->save();
    }
}
