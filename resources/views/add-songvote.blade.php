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

    
    <div class="mb-3">
        <label for="endingDate" class="form-label h3-label">Vote ending date</label>
        @if($errors->first('endingDate'))   
            <h5 class="errors">{{ $errors->first('endingDate') }}</h5>    
        @endif
        <input type="date" name="endingDate" class="form-control" value="{{ old('endingDate') }}" <?php if($errors->first('endingDate')) : ?> style="border-color: red"; <?php endif; ?>> 
    </div>

      
    <label class="form-label h3-label">Vote options</label>
    <p>Select options fans can vote for</p>
    @if($errors->first('songs'))   
        <h5 class="errors">{{ $errors->first('songs') }}</h5>    
    @endif
    <div class="song-vote">        
        @foreach ( $artistAlbums->items as $artistAlbum )
            <div>
                <div class="grey-row row albumDetails" id="{{ $artistAlbum->id }}">
                    <img class="album-cover" src="<?php echo $artistAlbum->images[0]->url; ?>" alt="album cover">
                    <h4 class="pl-2 my-auto" >{{ $artistAlbum->name }}</h4>
                </div>                
            </div>        
        @endforeach
    </div>
</div>    
@endsection

@section('steps')
<div class="bottom-nav">
        <div class="text-center">
            <span class="dot"></span>
            <span class="selected-dot dot"></span>
            <span class="dot"></span>
            <input class="nextBtn" type="submit" name="next" value="Next"></input>        
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
                    $("#" + albumId).after('<div class="row grey-row-sm album-tracks"><label class="pl-5 my-auto" style="font-size: 18px;" name="songs">' + response[i]['name'] + '</label><input type="checkbox" class="my-auto" style="width: 20px; display: inline-block; float:right; " class="pull-right" name="songs[]" id="' + response[i]['id'] +'"value="' + response[i]['id'] +'""></div>');  
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