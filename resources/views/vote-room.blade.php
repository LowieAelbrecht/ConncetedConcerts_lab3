@extends('layouts/back-nav')

@section('title')
    Song vote
@endsection

@section('content')
<div class="container mt-3">
    <div class="text-center">
        <h2>Vote</h2>
        <p>Click on a song you want to hear at the concert</p>
    </div>
    <div class="song-vote justify-content-center">
        <h5 class="days-left text-center">{{ $daysleft }} Days left</h5>
        @foreach( $songVoteOptions->tracks as $key => $songVoteOption)
            @if(empty($voted))
            <div class="row grey-row vote" id="{{ $songVoteOption->id }}">
                <h4 class="pl-2 my-auto" >{{ $key+1 }}</h4>
                <img class="album-cover" src="<?php echo $songVoteOption->album->images[0]->url; ?>" alt="album cover">
                <h4 class="pl-2 my-auto" >{{ $songVoteOption->name }}</h4>
                <input type="checkbox" class="my-auto">
            </div>
            @else 
                @foreach($songs as $song)
                    @if($song->song == $songVoteOption->id)
                        <div class="row grey-row vote" 
                             <?php if($voted->songSpotifyId != $songVoteOption->id) : ?>
                             style="background: linear-gradient(to right, #ff9e00 0%, #ff9e00 <?php echo  round((($song->votes)/$totalVotes)*100); ?>%, #ff9e00 <?php echo  round((($song->votes)/$totalVotes)*100); ?>%, #ddd <?php echo  round((($song->votes)/$totalVotes)*100); ?>%, #ddd 100%);" 
                             <?php else : ?>
                             style="background: linear-gradient(to right, #0094FF 0%, #0094FF <?php echo  round((($song->votes)/$totalVotes)*100); ?>%, #0094FF <?php echo  round((($song->votes)/$totalVotes)*100); ?>%, #ddd <?php echo  round((($song->votes)/$totalVotes)*100); ?>%, #ddd 100%);" 
                             <?php endif; ?>
                             id="{{ $songVoteOption->id }}">
                            <h4 class="pl-2 my-auto" >{{ $key+1 }}</h4>
                            <img class="album-cover" src="<?php echo $songVoteOption->album->images[0]->url; ?>" alt="album cover">
                            <h4 class="pl-2 my-auto" >{{ $songVoteOption->name }}</h4>
                            <h4 class="pl-2 my-auto">{{ round((($song->votes)/$totalVotes)*100) }}%</h4>
                        </div>                  
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>  
</div>    
@endsection

@section('steps')
    <div class="bottom-nav">
        <div class="justify-content-center row bottom-nav">
            <a class="row px-4" href="/social-room/{{ request()->route('concerts') }}">
                <i class="material-icons">people</i>
                <h5>Social</h5>
            </a>
            <a class="row px-4 selected-nav">
                <i class="material-icons">recommend</i>
                <h5>Vote</h5>
            </a>
            <a class="row px-4" href="/bingo-room/{{ request()->route('concerts') }}">
                <i class="material-icons">celebration</i>
                <h5>Bingo</h5>
            </a>                  
        </div>      
    </div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $(".vote").click(function(){
        var songId = $(this).attr("id");
        var url = window.location.pathname;
        var concertId = url.substring(url.lastIndexOf('/') + 1);
        console.log(concertId);

        $.ajax({
            url:'/insertVote',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "songId": songId,
                "concertId": concertId},
            dataType: 'json',
            success: function(response){
                location.reload(true); 
            }
        });

    });

});
</script>
@endsection