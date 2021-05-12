<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('accessToken')) {
            
        } else {
            // logout here
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
        return redirect('/user-home');     
    }

    public function index(Request $request)
    {
        return view('/user-home');
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
        return view('/settings');
    }
}
