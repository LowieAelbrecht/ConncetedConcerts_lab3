<?php
/*
NOG NA TE KIJKEN HOE DIT WERKT 
https://github.com/jwilsson/spotify-web-api-php/blob/main/docs/examples/access-token-with-authorization-code-flow.md
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Callback extends Controller
{
    public function index(Request $request)
    {     
        require '../vendor/autoload.php';

        $session = new \SpotifyWebAPI\Session(
            'c3ee0d861721448dbecc1b0c475b29e4',
            '056c230dbe804f16aa56d45718175c4a',
            'https://ancient-parrot-67.loca.lt/callback'
        );

        $api = new \SpotifyWebAPI\SpotifyWebAPI();

        // Request a access token using the code from Spotify
        $session->requestAccessToken($_GET['code']);

        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        //session()->put('accessToken', $accessToken);
        //session(['accessToken' => $accessToken]);
        $request->session()->put('accessToken', $accessToken);
        $request->session()->put('refreshToken', $refreshToken);


        // Store the access and refresh tokens somewhere. In a session for example

        // Send the user along and fetch some data!
        //header('Location: http://ConnectedConcerts.test/user-home');
        $url = "https://ancient-parrot-67.loca.lt/checkUser";
        return \Illuminate\Support\Facades\Redirect::to($url);
        die();
    }
}

