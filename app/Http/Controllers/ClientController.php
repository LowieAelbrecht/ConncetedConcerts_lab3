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
        return view('/choose-user');
    }

    public function fixUser(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        if($request->input('user') == true){
            $request->session()->put('userType', 'user');
            $me = $api->me();
            $request->session()->put('userSpotifyId', ($me->id));
            $users = \DB::table('users')->where('token', ($me->id))->first();

            if(empty($users)){
                \DB::table('users')->insert([
                    'name' => $me->display_name,
                    'token' => $me->id
                ]);
            }

            return redirect('/user-rooms'); 
        } elseif($request->input('artist') == true){
            $request->session()->put('userType', 'artist');
            $request->session()->put('artistSpotifyId', '2Sm4rGKWBnOQhdqDy4JJh0');
            $artist = \DB::table('artists')->where('token', session()->get('artistSpotifyId'))->first();
            $artistinfo = $api->getArtist('2Sm4rGKWBnOQhdqDy4JJh0');

            if(empty($artist)){
                $artistId = \DB::table('artists')->insertGetId([
                    'name' => $artistinfo->name,
                    'token' => $artistinfo->id
                ]);
            } else {
                $artistId = $artist->id;
            }

            $request->session()->put('artistId', $artistId);
        }

        return redirect('/user-rooms');         
    }

    public function change(Request $request)
    { 
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        if((session()->get('userType')) == ("user")){
            $request->session()->put('userType', 'artist');
            $request->session()->put('artistSpotifyId', '2Sm4rGKWBnOQhdqDy4JJh0');
            $artist = \DB::table('artists')->where('token', session()->get('artistSpotifyId'))->first();
            $artistinfo = $api->getArtist('2Sm4rGKWBnOQhdqDy4JJh0');

            if(empty($artist)){
                $artistId = \DB::table('artists')->insertGetId([
                    'name' => $artistinfo->name,
                    'token' => $artistinfo->id
                ]);
            } else {
                $artistId = $artist->id;
            }

            $request->session()->put('artistId', $artistId);
        } else {
            $request->session()->put('userType', 'user');
        }
        
        return redirect('/settings');
    }

    public function index(Request $request)
    {
        if((session()->get('userType')) == ("artist")){
           $data['myConcerts'] = \DB::table('concerts')->where('artist_id', session()->get('artistId'))->get();
           //var_dump($data['myConcerts']);
        } else {
            $data['myConcerts'] = 'kijken in welke concerten gebruiker is ingekocht';
        }

        if($_GET){
            return redirect('/add-concert');
        }

        return view('/user-rooms', $data);
    }

    public function discover(Request $request)
    {
        $data['concerts'] = \DB::table('concerts')
        ->whereRaw('Date(concert_date) >= CURDATE()')
        ->where('published', '1')
        ->orderBy('concert_date', 'asc')
        ->get();

        return view('/user-discover', $data);
    }
    
    public function showConcert($concerts)
    {
        $data['concert'] = \DB::table('concerts')->where('id', $concerts)->first();
        //dd($data['concert']);

        if($_GET){
            return redirect('/concertspayment/{concerts})');
        }
        
        return view('/concert', $data);
    }

    public function profile(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        if((session()->get('userType')) == ("user")){
            $data['profile'] = $api->me();
        } else {
            $data['profile'] = $api->getArtist(session()->get('artistSpotifyId'));
            
        }
        
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
