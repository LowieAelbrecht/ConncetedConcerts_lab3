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

    public function updateConcert(Request $request, $concert)
    {
        $data['myConcert'] = \DB::table('concerts')
            ->where('artist_id', session()->get('artistId'))
            ->where('id', $concert)
            ->first();

        return view('/update-concert', $data);
    }

    public function saveUpdateConcert(Request $request, $concert)
    {
        $date = $request->input('date') . " " .  $request->input('time');
        //$newImageName = time() . '-' . $request->concertName . '.' . $request->photo->extension(); 
        //$request->photo->move(public_path('uploads'), $newImageName);

        switch ($request->input('action')) {
            case 'publish':
                \DB::table('concerts')
                ->where('id', $concert)
                ->update(
                    ['name' => $request->input('concertName'), 
                    'locatie' => $request->input('location'),
                    'concert_date' => $date,
                    'prijs' => $request->input('price'),
                   // 'file_path' => $newImageName,
                    'published' => true
                ]
                );
                return redirect('/update-concert/' . $concert); 
                break;
    
            case 'save':
                \DB::table('concerts')
                ->where('id', $concert)
                ->update(
                    ['name' => $request->input('concertName'), 
                    'locatie' => $request->input('location'),
                    'concert_date' => $date,
                    'prijs' => $request->input('price'),
                   // 'file_path' => $newImageName,
                    'published' => false
                ]
                );
                return redirect('/update-concert/' . $concert);  
                break;
            }       
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

    public function storeBingo(Request $request)
    {       
        $request->flash();
        $concertId = $request->session()->get('concertId');
        
        foreach(($request->input('name')) as $key => $item){

            $newImageName[$key] = time() . '-' . $request->name[$key] . '.' . $request->photo[$key]->extension();
            // store image in public uploads folder    
            $request->photo[$key]->move(public_path('uploads'), $newImageName[$key]);
            /*
            $request->validate([
                'name' => 'required',
                'amount' => 'required',
                'info' => 'required',
                'photo' => 'required|mimes:jpg,png,jpeg'
            ]);
            */

            \DB::table('bingo')->insertOrIgnore(
                ['item_name' => $item,
                'item_amount' => ($request->input('amount'))[$key],
                'item_info' => ($request->input('info'))[$key], 
                'concert_id' => $concertId,
                'file_path' => $newImageName[$key]
                ]
            );
        }
        
        return redirect('/finish-concert');
    }

    public function finishConcert(Request $request)
    {
        $concertId = $request->session()->get('concertId');
        $data['myConcert'] = \DB::table('concerts')
        ->where('id', $concertId)
        ->first();

        return view('/finish-concert', $data);
    }

    public function publishConcert(Request $request)
    {
        $concertId = $request->session()->get('concertId');

        switch ($request->input('action')) {
            case 'publish':
                \DB::table('concerts')
                ->where('id', $concertId)
                ->update(
                    [
                    'published' => true
                ]
                );
                break;

            }

            
        return redirect('/user-rooms'); 
    }

    public function bingoResults(Request $request, $concert)
    {
        $users = \DB::table('userconcerts')->where('concert_id', $concert)->get();

        $userIds = array(); 

        foreach($users as $user){
            $userId = $user->user_id;
            array_push($userIds, $userId); 
        }

        shuffle($userIds);
        $winnerIds = array();

        $prices = \DB::table('bingo')->where('concert_id', $concert)->get();
        foreach($prices as $price){
            $winnerIds[$price->id] = array();
            for($x = 0; $x < $price->item_amount; $x++){
                $winnerId = array_pop($userIds);
                \DB::table('userbingo')->insertOrIgnore(
                    ['user_id' => $winnerId,
                    'bingo_id' => $price->id,
                    'concert_id' => $concert 
                    ]
                ); 
            } 
        }     
        
        return redirect('/bingo-room/' . $concert); 
    }

    public function addPost(Request $request, $concert)
    {
        return view('/add-post');
    }

    public function checkReceived()
    {
        $id = $_POST['id'];
        $checked = $_POST['checked'];

        if($checked == false){
            \DB::table('userbingo')
                ->where('id', $id)
                ->update(
                    ['received' => true 
                ]
                );

        } else {
            \DB::table('userbingo')
                ->where('id', $id)
                ->update(
                    ['received' => false
                ]
                );
        }

    }

        
}
