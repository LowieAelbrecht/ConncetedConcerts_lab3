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
     <hr class="mt-2">
     @for($x = 0; $x < $hasCommments; $x++)
     <div>
         <div class="row">
            @if($comments[$x]->spotify_token == $commenters[$x]->id)
            <div class="col-3">
                <img class="post-profile-image" src="<?php echo $commenters[$x]->images[0]->url; ?>" alt="profile_image">
            </div>
            @endif
            <div class="col-auto p-0">
            @if($comments[$x]->spotify_token == $commenters[$x]->id && $commenters[$x]->type == "user")
                <h5>{{ $commenters[$x]->display_name }}</h5> 
            @elseif($comments[$x]->spotify_token == $commenters[$x]->id && $commenters[$x]->type == "artist")
                <h5>{{ $commenters[$x]->name }}</h5> 
            @endif
            <p>{{$comments[$x]->tekst}}</p>
            </div>
        </div>    
        <h6>{{ date("H:i  d/m/'y ", strtotime($comments[$x]->comment_date)) }}</h6>
        <hr>
     </div>
     @endfor
     <div href="#" class="input-container">
        <textarea id="txtArea" class="commentbox" type="text" name="comment" placeholder="Write a comment..." <?php if($errors->first('comment')) : ?> style="border-color: red"; <?php endif; ?>></textarea> 
        <i class="material-icons" id="add-comment">arrow_forward</i>
    </div> 
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $("#add-comment").click(function(){
        comment();
    });

    $(document).on("keypress", function(e){
        if(e.which == 13){
            comment();
        }
    });
    
        function comment(){
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
    }
           

});   
</script>
@endsection