<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        if(session()->get('artistSpotifyId') == "4oMBP1OWXtmxyDhAj2aRyQ"){
            $urlAPI = 'https://app.ticketmaster.com/discovery/v2/events.json?countryCode=BE&keyword=balthazar&apikey=kv2FiO7Vt292weDyR45Muj2uPVbTSpsb';
        }
        elseif(session()->get('artistSpotifyId') == "4nljEo4gnUFgczxjNt5KOR"){
            $urlAPI = 'https://app.ticketmaster.com/discovery/v2/events.json?countryCode=BE&keyword=equal-idiots&apikey=kv2FiO7Vt292weDyR45Muj2uPVbTSpsb';
        }
        elseif(session()->get('artistSpotifyId') == "5EP020iZcwBqHRnJftibXX"){
            $urlAPI = 'https://app.ticketmaster.com/discovery/v2/events.json?countryCode=BE&keyword=hooverphonic&apikey=kv2FiO7Vt292weDyR45Muj2uPVbTSpsb';
        }
        elseif(session()->get('artistSpotifyId') == "6mo0UbyIvIePdXNyLwQlk5"){
            $urlAPI = 'https://app.ticketmaster.com/discovery/v2/events.json?countryCode=BE&keyword=milow&apikey=kv2FiO7Vt292weDyR45Muj2uPVbTSpsb';
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $urlAPI);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        curl_close($ch);
        $list = json_decode($response, true);
        $data['concerts'] = $list['_embedded']['events'];

        //dd($data['concerts']);

        $myConcerts = \DB::table('concerts')
            ->where('artist_id', session()->get('artistId'))
            ->get();

        $data['myConcerts'] = array();


        foreach($myConcerts as $myConcert){
            $concerts = $myConcert->tm_id;
            array_push($data['myConcerts'], $concerts); 
        }
        

        return view('/add-concert', $data);
    }

    public function storeConcert(Request $request)
    {   
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $artistinfo = $api->getArtist(session()->get('artistSpotifyId'));
        $artistId = $request->session()->get('artistId');

        // Get all data from form
        $jqdate = $_POST['dateTime'];
        $artistName = $artistinfo->name;
        $concertName = $_POST['concertName'];
        $locatie = ($_POST['venue'] . " | " . $_POST['city']);
        $date = date(preg_replace('/T|\Z/', ' ', $jqdate));
        $prijs = "0";
        $img = $_POST['img'];
        $tm = $_POST['tm_id'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        
        // Store in DB
        $concertId = \DB::table('concerts')->insertGetId(
            ['name' => $concertName, 
            'artist_name' => $artistName,
            'locatie' => $locatie,
            'concert_date' => $date,
            'prijs' => $prijs,
            'file_path' => $img,
            'tm_id' => $tm,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'artist_id' => $artistId
            ]
        );

        $request->session()->put('concertId', $concertId);
        
        echo json_encode(true); 
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
            'songs' => 'required|array|min:2'
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
                'name'=> 'required',
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
        $price = $request->input('price');

        switch ($request->input('action')) {
            case 'publish':
                \DB::table('concerts')
                ->where('id', $concertId)
                ->update(
                    [
                    'prijs' => $price,   
                    'published' => true
                ]
                );
                break;

            case 'save':
                \DB::table('concerts')
                ->where('id', $concertId)
                ->update(
                    [
                    'prijs' => $price
                ]
                );
                break;
            }

        $request->session()->forget('concertId');

            
        return redirect('/user-rooms'); 
    }

    public function deleteRoom(Request $request)
    {
        $concertId = $request->session()->get('concertId');
        \DB::table('concerts')->where('id', $concertId)->delete();

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

    public function storePost(Request $request, $concert)
    {   
        $request->validate([
            'title' => 'required',
            'tekst' => 'required',
            'photo' => 'sometimes|mimes:jpg,png,jpeg,mp4,mov,avi'
        ]);  
        
        $now = date("Y-m-d H:i:s");
        $artistSpotifyId = session()->get('artistSpotifyId');
        $newImageName = 0;
        if(!empty($request->photo)){
        $newImageName = time() . '-' . $request->title . '.' . $request->photo->extension();

        // store image in public uploads folder    
        $request->photo->move(public_path('uploads'), $newImageName);
        }

        \DB::table('posts')->insertOrIgnore(
            ['title' => $request->input('title'),
            'tekst' => $request->input('tekst'),
            'post_date' => $now,
            'file_path' => $newImageName,
            'likes' => 0,
            'comments' => 0,
            'profile_image_artist' => $artistSpotifyId,
            'concert_id' => $concert
            ]
        );
        return redirect('/social-room/' . $concert); 
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
