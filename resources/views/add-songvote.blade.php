@extends('layouts/back-nav')

@section('title')
    Add song vote
@endsection

@section('content')
<form method="post" action="/add-songvote" enctype="multipart/form-data"> 
@csrf
<div class="container">
    <div class="text-center">
        <h2>Song vote</h2>
        <p>A poll where fans can vote for a song they want to hear at the performance, song with most votes will be played!</p>
    </div>

    <div>
        <label for="endingDate" class="form-label">Vote ending date</label>
        <input type="date" name="endingDate" class="form-control" value=""> 
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
            <input type="submit" name="next" value="Next"></input>
        </div>        
    </div>
</form>
@endsection

@section('js')
<script src="http://cdn.jsdelivr.net/jquery.cookie/1.4.0/jquery.cookie.min.js"></script>
<script>
$(document).ready(function(){
    $(".albumDetails").click(function(){
        var albumId = $(this).attr("id");

        $.ajax({
            url:'/getAlbumTracks',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "albumId": albumId},
            dataType: 'json',
            success: function(response){
                $('.album-tracks').hide();
                if(response.length > 0){  
                    for (var i = 0; i < response.length; i++){   
                    $("#" + albumId).after('<div class="row album-tracks"><label class="pl-5" name="songs">' + response[i]['name'] + '</label><input type="checkbox" name="songs[]" id="' + response[i]['id'] +'"value="' + response[i]['id'] +'""></div>');  
                    }                   
                } else {
                    $('.album-tracks').hide();
                }

                $(":checkbox").on("change", function(){
                        var checkboxValues = {};
                        $(":checkbox").each(function(){
                        checkboxValues[this.id] = this.checked;
                        });
                        $.cookie('checkboxValues', checkboxValues, { expires: 7, path: '/' })
                    });

                    function repopulateCheckboxes(){
                        var checkboxValues = $.cookie('checkboxValues');
                        if(checkboxValues){
                        Object.keys(checkboxValues).forEach(function(element) {
                            var checked = checkboxValues[element];
                            $("#" + element).prop('checked', checked);
                        });
                        }
                    }

                    $.cookie.json = true;
                    repopulateCheckboxes();
                        }
            });
        });

});




</script>    
@endsection