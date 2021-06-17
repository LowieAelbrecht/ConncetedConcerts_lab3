@extends('layouts/back-nav')

@section('title')
    profile
@endsection


@section('content')
<div class="profile container">
    <?php if((session()->get('userType')) == ("user")) : ?>
        <div class="row">
            <img class="profile-image" src="<?php echo $profile->images[0]->url; ?>" alt="profile_image">
            <h3 class="userProfileName"><?php echo $profile->display_name; ?></h3>
        </div>
    <?php else: ?>
        <div class="row">
            <img class="profile-image" src="<?php echo $profile->images[0]->url; ?>" alt="profile_image">
            <h3 class="userProfileName"><?php echo $profile->name; ?></h3>
        </div>
        <div class="mt-3">
        @if(!empty($amount))
            <h5 class="text-center mb-2">Top 3 voted songs</h5>
            <div class="song-overview justify-content-center">
                <h5 class="text-center">All time</h5>
            @foreach( $songVoteOptions->tracks as $key => $songVoteOption)
            
                @foreach($mostVoted as $key => $voted)
                    @if($key <= 2)
                        @if($voted->song == $songVoteOption->id)
                            <div class="row grey-row SongVote" style="background: linear-gradient(to right, #ff9e00 0%, #ff9e00 <?php echo  round((($voted->votes)/$totalVotes)*100); ?>%, #ff9e00 <?php echo  round((($voted->votes)/$totalVotes)*100); ?>%, #ddd <?php echo  round((($voted->votes)/$totalVotes)*100); ?>%, #ddd 100%);">
                            <h4 class="pl-2 my-auto-vote-rank" >{{ $key+1 }}</h4>
                            <div class="play"><audio id="<?php echo $key; ?>"><source src="<?php echo $songVoteOption->preview_url; ?>" /></audio><img class="album-cover" src="<?php echo $songVoteOption->album->images[0]->url; ?>" alt="album cover"><i class="material-icons">play_circle_filled</i></div>  
                            <h4 class="pl-2 my-auto-vote-titel" >{{ $songVoteOption->name }}</h4>
                            <h4 class="pl-2 my-auto-vote-perc">{{ round((($voted->votes)/$totalVotes)*100) }}%</h4> 
                        </div>
                        @endif
                    @endif
                @endforeach
            @endforeach
            </div>
        @endif
        </div>
    <?php endif; ?>
    
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $(".play").click(function(){
            var html = $(this).text();
            var key = $(this).children().attr("id");        
            
            if(html == "play_circle_filled"){
                $("#" + key).get(0).play();
                $(this).children('i').text("pause_circle_filled");
                console.log("play");
            } else {
                $("#" + key).get(0).pause();
                $(this).children('i').text("play_circle_filled");
                console.log("pause");
            }
            
            
        });
           

});
</script>
@endsection