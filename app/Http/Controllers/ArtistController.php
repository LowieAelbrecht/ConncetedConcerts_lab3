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
            $concertId = \DB::table('concerts')->insertGetId(
                ['name' => $concertName, 
                'artist_name' => $artistName,
                'locatie' => $locatie,
                'concert_date' => $date,
                'prijs' => $prijs,
                'file_path' => $newImageName,
                'artist_id' => $artistId
                ]
            );

            $request->session()->put('concertId', $concertId);
            
        }

        return redirect('/add-songvote'); 
    }

        
    public function addSongVote(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $data['artistAlbums'] = $api->getArtistAlbums(session()->get('artistSpotifyId'), ['include_groups' => 'album,single', 'market' => 'BE', 'limit' => '50']);
        //dd($data['artistAlbums']);


        return view('/add-songvote', $data);
    }

    public function storeSongVote(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $artistId = $request->session()->get('artistId');
        $concertId = $request->session()->get('concertId');
        $date = $request->input('endingDate');

        $request->validate([
            'endingDate' => 'required|date|after:tomorrow',
            'songs' => 'array|min:2'
        ]);

        foreach(($request->input('songs')) as $song){
            \DB::table('songvote')->insertOrIgnore(
                ['song' => $song,
                'votes' => '0',
                'concert_id' => $concertId, 
                'artist_id' => $artistId,
                'ending_date' => $date
                ]
            );
        }
        
        return redirect('/add-bingo');
    }


    public function getAlbumTracks(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $albumId = $_POST['albumId'];

        $data = $api->getAlbumTracks($albumId, ['market' => 'BE', 'limit' => '50'])->items;

        echo json_encode($data);
    }

    public function addBingo(Request $request)
    {
        return view('/add-bingo');
    }
        
}
