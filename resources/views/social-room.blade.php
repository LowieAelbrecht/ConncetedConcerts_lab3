@extends('layouts/back-nav')

@section('title')
    Social
@endsection

@section('content')
<div class="container post-page">
    <div class="text-center">
        <h2>Posts</h2>
    </div>
    @if(!empty($posts[0]))
        @foreach($posts as $post)
            <div class="bg-white post">
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
            </div>
            <div class="row like-comment">
                    <div class="col-6" id="{{ $post->id }}">
                        <div class="row d-flex justify-content-center <?php if((session()->get('userType')) == ("user")) : ?>like<?php endif; ?>">
                                @if(!in_array($post->id, $likedPosts))
                                <i class="material-icons">favorite_border</i>
                                @else
                                <i class="material-icons">favorite</i>
                                @endif
                            <p class="pl-1">{{ $post->likes }}</p>
                        </div>                         
                    </div>
                    <div class="col-6" id="{{ $post->id }}">
                        <a href="/comments/{{ request()->route('concerts') }}/post/{{ $post->id }}"> 
                            <div class="row d-flex justify-content-center">
                                <i class="material-icons">mode_comment</i>
                                <p class="pl-1">{{ $post->comments }}</p>
                            </div>
                        </a>                           
                    </div>         
            </div>             
        @endforeach
    @endif

    @if((session()->get('userType')) == ("artist"))
    <form action="/new-post/{{ request()->route('concerts') }}" method="get">
        <button class="btn-add bottom-nav-btn" type="submit" name="room" value="room">+</button>
    </form>
    @else 
    <form></form>
    @endif
</div>
@endsection

@section('steps')
    <div class="main-bottom-nav">
        <div class="justify-content-center row main-bottom-nav">
            <a class="row px-4 selected-nav">
                <i class="material-icons navSocial">people</i>
                <h5>Social</h5>
            </a>
            <a class="row px-4" href="/vote-room/{{ request()->route('concerts') }}">
                <i class="material-icons navSocial">recommend</i>
                <h5>Vote</h5>
            </a>
            <a class="row px-4" href="/bingo-room/{{ request()->route('concerts') }}">
                <i class="material-icons navSocial">celebration</i>
                <h5>Bingo</h5>
            </a>                  
        </div>      
    </div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $(".like").click(function(){
        var postId = $(this).parent().attr("id");
        var url = window.location.pathname;
        var concertId = url.substring(url.lastIndexOf('/') + 1);
        var html = $(this).children('i').text();

        if(html == "favorite_border"){                    
            $(this).children('i').text("favorite");

            $.ajax({
            url:'/likePost',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "postId": postId,
                "concertId": concertId},
            dataType: 'json',
            success: function(response){
                location.reload(true);                
                
            }
        });
        } else {
            $(this).children('i').text("favorite_border");

            $.ajax({
            url:'/unLikePost',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "postId": postId,
                "concertId": concertId},
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