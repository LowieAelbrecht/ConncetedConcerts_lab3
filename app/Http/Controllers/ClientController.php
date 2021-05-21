<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('accessToken')) {
            
        } else {
            echo "User should not be able to visis this pages";
        }
    }

    public function checkUser(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $me = $api->me();
        $request->session()->put('userId', ($me->id));
        $request->session()->put('userType', 'user');
        /*
        $artist = $api->getArtist($me->id);
        
        if($this->reason == "invalid id"){
            echo "not artist";
        } else {
            echo "artist";
            //return redirect('/artist-home');
        }
        var_dump($artist); 
        */
        
        return redirect('/rooms');     
    }

    public function change(Request $request)
    { 
        if((session()->get('userType')) == ("user")){
            $request->session()->put('userType', 'artist');
            $request->session()->put('artistId', '2Sm4rGKWBnOQhdqDy4JJh0');
        } else {
            $request->session()->put('userType', 'user');
        }
        
        return redirect('/settings');
    }

    public function index(Request $request)
    {
        return view('/user-rooms');
    }

    public function discover(Request $request)
    {
        $data['concerts'] = \DB::table('concerts')
        ->whereRaw('Date(concert_date) >= CURDATE()')
        ->orderBy('concert_date', 'asc')
        ->get();

        return view('/user-discover', $data);
    }
    
    public function showConcert($concerts){
        $concerts = \DB::table('concerts')->where('id', $concerts)->first();
        dd($concerts);
    }

    public function profile(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $data['profile'] = $api->me();
        return view('/user-profile', $data);
    }

    public function settings(Request $request)
    {
        if($_GET){
            $request->session()->flush();
            return redirect('/login');
        }
        return view('/settings');
    }
}
