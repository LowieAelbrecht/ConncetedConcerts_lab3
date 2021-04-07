<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class Login extends Controller
{
    public function index()
    {     
        if($_GET){
            require '../vendor/autoload.php';

            $session = new \SpotifyWebAPI\Session(
                'c3ee0d861721448dbecc1b0c475b29e4',
                '056c230dbe804f16aa56d45718175c4a',
                'http://ConnectedConcerts.test/callback'
            );

            $state = $session->generateState();
            $options = [
                'scope' => [
                    'playlist-read-private',
                    'user-read-private',
                ],
                'state' => $state,
            ];

            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
                    }
        return view('/login');
    }
}
