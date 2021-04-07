<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        {     
            require '../vendor/autoload.php';
    
            $session = new \SpotifyWebAPI\Session(
                'c3ee0d861721448dbecc1b0c475b29e4',
                '056c230dbe804f16aa56d45718175c4a',
                'http://ConnectedConcerts.test/callback'
            );
    
            $api = new \SpotifyWebAPI\SpotifyWebAPI();
    
            if (isset($_GET['code'])) {
                $session->requestAccessToken($_GET['code']);
                $api->setAccessToken($session->getAccessToken());
    
                print_r($api->me());
            } else {
                $options = [
                    'scope' => [
                        'user-read-email',
                    ],
                ];
    
                header('Location: ' . $session->getAuthorizeUrl($options));
                die();
            }
        }
    }
}
