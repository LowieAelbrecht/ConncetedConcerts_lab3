@extends('layouts/back-nav')

@section('title')
    Social
@endsection

@section('content')
<div class="container post-page">
    <div class="text-center">
        <h2>Posts</h2>
    </div>
    @if(!empty($posts))
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
                    <img class="post-image"  src="/uploads/{{ $post->file_path }}" class="" alt="Picture at a post">
                @endif 
            </div>
            <div class="row like-comment">
                <div class="col-6 text-center">
                    <i class="material-icons">favorite_border</i>
                </div>
                <div class="col-6 text-center">
                    <i class="material-icons">mode_comment</i>
                </div>            
            </div>             
        @endforeach
    @endif

    @if((session()->get('userType')) == ("artist"))
    <form action="/new-post/{{ request()->route('concerts') }}" method="get">
        <button class="btn-add bottom-nav-btn" type="submit" name="room" value="room">+</button>
    </form>
    @endif
</div>
@endsection

@section('steps')
    <div class="bottom-nav">
        <div class="justify-content-center row bottom-nav">
            <a class="row px-4 selected-nav">
                <i class="material-icons">people</i>
                <h5>Social</h5>
            </a>
            <a class="row px-4" href="/vote-room/{{ request()->route('concerts') }}">
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