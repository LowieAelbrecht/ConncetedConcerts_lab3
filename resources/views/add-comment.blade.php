@extends('layouts/comments')

@section('title')
    Comments
@endsection

@section('content')
<div class="container comments">
    <div class="row">
        <div class="col-3">
            <img class="post-profile-image" src="<?php echo $profile->images[0]->url; ?>" alt="profile_image">
        </div>
        <div class="col-auto p-0">
            <h4>{{ $post->title }}</h4>
            <h5>{{ date("H:i  d/m/'y ", strtotime($post->post_date)) }}</h5>
        </div>                 
    </div>
    <p>{{ $post->tekst }}</p>
    @if($post->file_path != 0)
        <img class="post-image" src="/uploads/{{ $post->file_path }}" class="" alt="Picture at a post">
    @endif
     <hr>
     @for($x = 0; $x < $hasCommments; $x++)
     <div>
        @if($comments[$x]->spotify_token == $commenters[$x]->id)
        <img class="post-profile-image" src="<?php echo $commenters[$x]->images[0]->url; ?>" alt="profile_image">
        @endif
            @if($comments[$x]->spotify_token == $commenters[$x]->id && $commenters[$x]->type == "user")
               <h4>{{ $commenters[$x]->display_name }}</h4> 
            @elseif($comments[$x]->spotify_token == $commenters[$x]->id && $commenters[$x]->type == "artist")
                <h4>{{ $commenters[$x]->name }}</h4> 
            @endif
        <p>{{$comments[$x]->tekst}}</p>
        <h6><p>{{ date("H:i  d/m/'y ", strtotime($comments[$x]->comment_date)) }}</p></h6>
        <hr>
     </div>
     @endfor
     <div href="#" class="input-container">
        <textarea id="txtArea" class="commentbox" type="text" name="comment" placeholder="Write a comment..."></textarea> 
        <i class="material-icons" id="add-comment">arrow_forward</i>
    </div> 
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $("#add-comment").click(function(){
        var comment = $("#txtArea").val();
        var url = window.location.pathname;
        var postId = url.substring(url.lastIndexOf('/') + 1);        

        if(comment != ''){
            $.ajax({
            url:'/addComment',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "postId": postId,
                "comment": comment},
            dataType: 'json',
            success: function(response){
                location.reload(true);                
                
            }
        });
        }
    });
           

});   
</script>
@endsection