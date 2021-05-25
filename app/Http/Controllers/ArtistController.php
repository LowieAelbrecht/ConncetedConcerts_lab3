<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('accessToken')) {
            
        } else {
            echo "User should not be able to visis this pages";
        }
    }

    public function addConcert(Request $request)
    {
        return view('/add-concert');
    }

    public function storeConcert(Request $request)
    {   
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $artistinfo = $api->getArtist(session()->get('artistSpotifyId'));
        $artistId = $request->session()->get('artistId');

        $request->validate([
            'concertName' => 'required',
            'location' => 'required',
            'date' => 'required|date|after:tomorrow',
            'time' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg'
        ]);

        if($request->hasFile('photo')){
            // Get all data from form
            $artistName = $artistinfo->name;
            $concertName = $request->input('concertName');
            $locatie = $request->input('location');
            $date = $request->input('date') . " " .  $request->input('time');
            $prijs = $request->input('price');
            $newImageName = time() . '-' . $request->concertName . '.' . $request->photo->extension();

            // store image in public uploads folder    
            $request->photo->move(public_path('uploads'), $newImageName);
            
            // Store in DB
            \DB::table('concerts')->insert(
                ['name' => $concertName, 
                'artist_name' => $artistName,
                'locatie' => $locatie,
                'concert_date' => $date,
                'prijs' => $prijs,
                'file_path' => $newImageName,
                'artist_id' => $artistId
                ]
            );
            
        }

        return redirect('/add-songvote'); 
    }

        
    public function addSongVote(Request $request)
    {
        return view('/add-songvote');
    }
        
}
