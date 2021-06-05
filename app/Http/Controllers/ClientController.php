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
                $userId =\DB::table('users')->insertGetId([
                    'name' => $me->display_name,
                    'token' => $me->id
                ]);
            } else {
                $userId = $users->id;
            }

            $request->session()->put('userId', $userId);

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
           $data['published'] = \DB::table('concerts')->where('artist_id', session()->get('artistId'))->where('published', true)->first();
           $data['unPublished'] = \DB::table('concerts')->where('artist_id', session()->get('artistId'))->where('published', false)->first();
           //var_dump($data['myConcerts']);
        } else {
            $concertCheck = \DB::table('userconcerts')
            ->where('user_id', session()->get('userId'))
            ->get();      
            
            $data['amount'] = count($concertCheck);

            if(!empty($concertCheck)){
                for($x = 0; $x < $data['amount']; $x++){
                $concertId = $concertCheck[$x]->concert_id;
                $data['myConcerts'][$x] = \DB::table('concerts')->where('id', $concertId)->get();
                }
            }
        }

        if($_GET){
            return redirect('/add-concert');
        }

        return view('/user-rooms', $data);
    }

    public function discover(Request $request)
    {
        $concertCheck = \DB::table('userconcerts')
            ->where('user_id', session()->get('userId'))
            ->get(); 
            
            $data['amount'] = count($concertCheck);
            $data['concertIds'] = array();

            for($x = 0; $x < $data['amount']; $x++){
                $concertId = $concertCheck[$x]->concert_id;
                array_push($data['concertIds'], $concertId); 
            }

        $data['concerts'] = \DB::table('concerts')
        ->whereRaw('Date(concert_date) >= CURDATE()')
        ->where('published', '1')
        ->orderBy('concert_date', 'asc')
        ->get();

        return view('/user-discover', $data);
    }
    
    public function showConcert($concerts)
    {
        $concertCheck = \DB::table('userconcerts')
            ->where('user_id', session()->get('userId'))
            ->where('concert_id', $concerts)
            ->first();
  
                  
        if(empty($concertCheck)){
        $data['concert'] = \DB::table('concerts')->where('id', $concerts)->first();

        if($_GET){
            return redirect('/concertspayment/' . $data['concert']->id);            
        }
        
        return view('/concert', $data);
        }
    }

    public function socialConcert($concerts)
    {
        return view('/social-room');
    }

    public function voteConcert(Request $request, $concerts)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $userId = $request->session()->get('userId');

        $data['songs'] = \DB::table('songvote')
            ->where('concert_id', $concerts)
            ->orderBy('votes', 'desc')
            ->get(); 

        $data['amount'] = count($data['songs']);
        
        
        $trackIds = array();

        for($x = 0; $x < $data['amount']; $x++){
            $songId = $data['songs'][$x]->song;
            array_push($trackIds, $songId); 
        }

        $future = strtotime($data['songs'][0]->ending_date);
        $now = time();
        $timeleft = $future-$now;
        $data['daysleft'] = round((($timeleft/24)/60)/60); 

        $data['songVoteOptions'] = $api->getTracks($trackIds, []);

        $data['voted'] = \DB::table('usersongvote')
            ->where('concert_id', $concerts)
            ->where('user_id', $userId)
            ->first();

        if(!empty($data['voted'])){
            $data['totalVotes'] = 0;
            for($x = 0; $x < $data['amount']; $x++){
                $votes = $data['songs'][$x]->votes;
                $data['totalVotes'] = $data['totalVotes'] + $votes; 
            }
            //dd($totalVotes);  
        }        
          

        //dd($data['songVoteOptions']);   

        return view('/vote-room', $data);
    }

    public function insertVote(Request $request)
    {
        $songId = $_POST['songId'];
        $concertId = $_POST['concertId'];
        $userId = $request->session()->get('userId');

        $voted = \DB::table('usersongvote')
            ->where('concert_id', $concertId)
            ->where('user_id', $userId)
            ->first();

        if(empty($voted)){
            \DB::table('usersongvote')->insert(
                ['user_id' => $userId, 
                'concert_id' => $concertId,
                'songSpotifyId' => $songId
                ]
            );
            \DB::table('songvote')
                ->where('concert_id', $concertId)
                ->where('song', $songId)
                ->update(['votes'=> \DB::raw('votes+1')]);
        } else {
            \DB::table('songvote')
                ->where('concert_id', $concertId)
                ->where('song', $voted->songSpotifyId)
                ->update(['votes'=> \DB::raw('votes-1')]);
            \DB::table('usersongvote')
                ->where('concert_id', $concertId)
                ->where('user_id', $userId)
                ->update(['songSpotifyId' => $songId]);
                
            \DB::table('songvote')
                ->where('concert_id', $concertId)
                ->where('song', $songId)
                ->update(['votes'=> \DB::raw('votes+1')]);       
        }

        echo json_encode(true);
    }

    public function bingoConcert($concerts)
    {
        return view('/bingo-room');
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
