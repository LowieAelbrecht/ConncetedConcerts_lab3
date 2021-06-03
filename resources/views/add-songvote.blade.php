@extends('layouts/back-nav')

@section('title')
    Add song vote
@endsection

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Song vote</h2>
        <p>A poll where fans can vote for a song they want to hear at the performance, song with most votes will be played!</p>
    </div>

    <div>
        <label for="ending-date" class="form-label">Vote ending date</label>
        <input type="text" name="ending-date" class="form-control" value=""> 
    </div>


    <label class="form-label">Vote options</label>
    <p>Select options fans can vote for</p>
    <div class="song-vote">        
        @foreach ( $artistAlbums->items as $artistAlbum )
            <div class="grey-row">
                <div class="row albumDetails" id="{{ $artistAlbum->id }}">
                    <img class="album-cover" src="<?php echo $artistAlbum->images[0]->url; ?>" alt="album cover">
                    <h4 class="pl-2 my-auto" >{{ $artistAlbum->name }}</h4>
                </div>                
            </div>        
        @endforeach
    </div>
</div>    
@endsection

@section('steps')
        <div class="steps row justify-content-center">
            <div class="text-center">
                <h5>Song vote</h5>
                <span class="dot"></span>
                <span class="selected-dot dot"></span>
                <span class="dot"></span>        
            </div>
            <div class="pull-right">
                <input type="submit" name="upload" value="Next"></input>
            </div>        
        </div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $(".albumDetails").click(function(){
        var albumId = $(this).attr("id");
        console.log(albumId);

        $.ajax({
            url:'/getAlbumTracks',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "albumId": albumId},
            dataType: 'json',
            success: function(response){
                $('.album-tracks').remove();
                if(response.length > 0){  
                    for (var i = 0; i < response.length; i++){   
                    $("#" + albumId).after('<div class="row album-tracks"><label class="pl-5">' + response[i]['name'] + '</label><input type="checkbox" id="' + response[i]['id'] +'"value="' + response[i]['id'] +'""></div>');  
                    }                   
                } else {
                    $('.album-tracks').remove();
                }
        }
    });
});

});
</script>    
@endsection