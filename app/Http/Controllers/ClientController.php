<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(Request $request)
    {    
        require '../vendor/autoload.php';

        $api = new \SpotifyWebAPI\SpotifyWebAPI();

        //$accessToken = session('accessToken');
        $accessToken = $request->session()->get('accessToken');
        if ($request->session()->has('accessToken')) {
            $url = $request->url();
            echo $url;
        }
        
        echo "hello";
        //var_dump($accessToken);
        
        $data = $request->session()->all();

        print_r($data);
        

        $api->setAccessToken($accessToken);
        //print_r($api->me());             
    }

    public function index()
    {
        return view('/user-home');
    }

    public function profile()
    {
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        //print_r($api->me());
        return view('/profile');
    }

    public function settings()
    {
        return view('/settings');
    }
}
