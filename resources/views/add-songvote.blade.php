@extends('layouts/back-nav')

@section('title')
    Add song vote
@endsection

@section('content')
    <h2 class="text-center">Song vote</h2>
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
                if(response.length > 0){  
                    for (var i = 0; i < response.length; i++){   
                    $("#" + albumId).after('<div class="row"><label class="pl-5">' + response[i]['name'] + '</label><input type="checkbox" id="' + response[i]['id'] +'"value="' + response[i]['id'] +'""></div>');  
                    }                   
                }
        }
    });
});

});
</script>    
@endsection