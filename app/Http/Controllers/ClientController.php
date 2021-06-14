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
            return redirect('/choose-artist');
        }
            

        return redirect('/user-rooms');         
    }

    public function chooseArtist(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $data['balthazar'] = $api->getArtist('4oMBP1OWXtmxyDhAj2aRyQ');
        $data['blackwave'] = $api->getArtist('0nvdwVbj7NT1WL9P8JowLD');
        $data['hooverphonic'] = $api->getArtist('5EP020iZcwBqHRnJftibXX');
        $data['milow'] = $api->getArtist('6mo0UbyIvIePdXNyLwQlk5');

        return view('/choose-artist', $data);
    }

    public function storeArtist(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $request->session()->put('userType', 'artist');

        if($request->input('balthazar') == true){
            $request->session()->put('artistSpotifyId', '4oMBP1OWXtmxyDhAj2aRyQ');
        }
        elseif($request->input('blackwave') == true){
            $request->session()->put('artistSpotifyId', '0nvdwVbj7NT1WL9P8JowLD');
        }
        elseif($request->input('hooverphonic') == true){
            $request->session()->put('artistSpotifyId', '5EP020iZcwBqHRnJftibXX');
        }
        elseif($request->input('milow') == true){
            $request->session()->put('artistSpotifyId', '6mo0UbyIvIePdXNyLwQlk5');
        }
            
                
        $artist = \DB::table('artists')->where('token', session()->get('artistSpotifyId'))->first();
        $artistinfo = $api->getArtist(session()->get('artistSpotifyId'));

        if(empty($artist)){
            $artistId = \DB::table('artists')->insertGetId([
                'name' => $artistinfo->name,
                'token' => $artistinfo->id
            ]);
        } else {
            $artistId = $artist->id;
        }

        $request->session()->put('artistId', $artistId);

        return redirect('/user-rooms');            
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
  
        $data['bingoPrices'] = \DB::table('bingo')->where('concert_id', $concerts)->get();
        
        $data['prices'] = count($data['bingoPrices']);

                  
        if(empty($concertCheck)){
        $data['concert'] = \DB::table('concerts')->where('id', $concerts)->first();

        
        return view('/concert', $data);
        }
    }

    public function socialConcert(Request $request, $concerts)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $data['posts'] = \DB::table('posts')
            ->where('concert_id', $concerts)
            ->orderBy('post_date', 'desc')
            ->get();
        
        $posts = count($data['posts']);
       

        if($posts > 0){
            $artistSpotifyId = \DB::table('posts')
            ->where('concert_id', $concerts)
            ->first()->profile_image_artist; 

        $data['profile'] = $api->getArtist($artistSpotifyId);

        $data['likedPosts'] = array();

        $likedPosts = \DB::table('likes')
                ->where('user_id', $request->session()->get('userId'))
                ->get();

        $likedPostsCount = count($likedPosts);        
            

        for($x = 0; $x < $likedPostsCount; $x++){
            $likedPost = $likedPosts[$x]->post_id;
            array_push($data['likedPosts'], $likedPost);
        }

            //dd($data['likedPosts']);

        }
        
        return view('/social-room', $data);
    }

    public function likePost(Request $request)
    {
        $postId = $_POST['postId'];
        $concertId = $_POST['concertId'];
        $userId = $request->session()->get('userId');

        \DB::table('likes')->insertOrIgnore([
            'post_id' => $postId,
            'user_id' => $userId,
            'concert_id' => $concertId
        ]);

        \DB::table('posts')
            ->where('concert_id', $concertId)
            ->where('id', $postId)
            ->update(['likes'=> \DB::raw('likes+1')]);        
        
        echo json_encode(true);
    }

    public function unLikePost(Request $request)
    {
        $postId = $_POST['postId'];
        $concertId = $_POST['concertId'];
        $userId = $request->session()->get('userId');
        
        \DB::table('likes')->where([
            'post_id' => $postId,
            'user_id' => $userId,
            'concert_id' => $concertId
        ])->delete();        

        \DB::table('posts')
            ->where('concert_id', $concertId)
            ->where('id', $postId)
            ->update(['likes'=> \DB::raw('likes-1')]);        
        
        echo json_encode(true);
    }

    public function addComment(Request $request, $concerts, $post)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $data['post'] = \DB::table('posts')
            ->where('id', $post)
            ->first();

        $data['comments'] = \DB::table('comments')
        ->where('post_id', $post)
        ->get();

        $data['hasCommments'] = count($data['comments']);
        
        if($data['hasCommments'] > 0){
        
            $data['commenters'] = array();

            foreach($data['comments'] as $comment)
            {
            if(($comment->user_type) == ("user")){
                $commentUser = $api->getUser($comment->spotify_token);
                array_push($data['commenters'], $commentUser);
            } else {
                $commentUser = $api->getArtist($comment->spotify_token);
                array_push($data['commenters'], $commentUser);
            }
        }
        }
        
        $data['profile'] = $api->getArtist($data['post']->profile_image_artist);

        return view('/add-comment', $data);
    }

    public function storeComment(Request $request)
    {
        $postId = $_POST['postId'];
        $comment = $_POST['comment'];
        $userType = $request->session()->get('userType');
        $now = date("Y-m-d H:i:s");

        if($userType == "user"){
            $token = $request->session()->get('userSpotifyId');
            \DB::table('comments')->insertOrIgnore([
                'tekst' => $comment,
                'comment_date' => $now,
                'post_id' => $postId,
                'user_type' => 'user',
                'spotify_token' => $token
            ]);
        }else {
            $token = $request->session()->get('artistSpotifyId');
            \DB::table('comments')->insertOrIgnore([
                'tekst' => $comment,
                'comment_date' => $now,
                'post_id' => $postId,
                'user_type' => 'artist',
                'spotify_token' => $token
            ]);
        }

        \DB::table('posts')
            ->where('id', $postId)
            ->update(['comments'=> \DB::raw('comments+1')]);  
            
        echo json_encode(true);
    }


    public function voteConcert(Request $request, $concerts)
    {
        $accessToken = $request->session()->get('accessToken');
        $api = new \SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $userId = $request->session()->get('userId');
        $userType = $request->session()->get('userType');

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
        //dd($data['songVoteOptions']);

        $data['voted'] = \DB::table('usersongvote')
            ->where('concert_id', $concerts)
            ->where('user_id', $userId)
            ->first();

        if($userType == 'user'){
            if(!empty($data['voted'])){
                $data['totalVotes'] = 0;
                for($x = 0; $x < $data['amount']; $x++){
                    $votes = $data['songs'][$x]->votes;
                    $data['totalVotes'] = $data['totalVotes'] + $votes; 
                }
            } 
        } else {
            $data['totalVotes'] = 0;
            for($x = 0; $x < $data['amount']; $x++){
                $votes = $data['songs'][$x]->votes;
                $data['totalVotes'] = $data['totalVotes'] + $votes; 
            }
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
        $data['bingoPrices'] = \DB::table('bingo')->where('concert_id', $concerts)->get();

        $data['bingoResults'] = \DB::table('userbingo')->where('concert_id', $concerts)->get();


        if((session()->get('userType')) == ("user")){
            $data['winnerOrNot'] = \DB::table('userbingo')
                                        ->where('concert_id', $concerts)
                                        ->where('user_id', (session()->get('userId')))
                                        ->first();

            if(!empty($data['winnerOrNot'])){
                $data['user'] = \DB::table('users')->where('id', (session()->get('userId')))->first();
                $data['price'] = \DB::table('bingo')->where('id', $data['winnerOrNot']->bingo_id)->first();
            }                          

        } elseif((session()->get('userType')) == ("artist")){
            $data['users'] = array();

        foreach($data['bingoResults'] as $result){
            $user = \DB::table('users')
                ->where('id', $result->user_id)
                ->first();
            array_push($data['users'], $user);
        }

        $data['prices'] = array();

        foreach($data['bingoPrices'] as $result){
            $price = \DB::table('bingo')
                ->where('id', $result->id)
                ->first();
            array_push($data['prices'], $price);
        }
        }


        return view('/bingo-room', $data);
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

    public function search()
    {
        $target = $_POST['target'];

        $data = \DB::table('concerts')
                                ->where('name', 'LIKE', '%'.$target.'%')
                                ->orWhere('artist_name', 'LIKE', '%'.$target.'%')
                                ->orWhere('locatie', 'LIKE', '%'.$target.'%')
                                ->get();


        $data = json_decode($data, true);

        echo json_encode($data);
    }

    public function concertCheck()
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

        echo json_encode($data['concertIds']);
    }

    public function sortDistance()
    {
        $id = $_POST['ids'];

        $data = \DB::table('concerts')
            ->where('id', $id)
            ->first(); 


        echo json_encode($data);
    }
}
