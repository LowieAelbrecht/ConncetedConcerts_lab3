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
        /*
        $id = $me->id;
        $artist = $api->getArtist('6V49rvx2KPFjV4fmFsguWX');
        var_dump($artist);
        die;
        if($artist == "invalid id"){
            echo "not artist";
        } else {
            echo "artist";
        }
        var_dump($artist); 
        */
        return redirect('/user-rooms');     
    }

    public function index(Request $request)
    {
        return view('/user-rooms');
    }

    public function discover(Request $request)
    {
        $data['concerts'] = \DB::table('concerts')->get();

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
