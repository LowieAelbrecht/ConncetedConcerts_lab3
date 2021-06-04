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
            <div class="row grey-row">
                <h4 class="pl-2 my-auto" >{{ $key+1 }}</h4>
                <img class="album-cover" src="<?php echo $songVoteOption->album->images[0]->url; ?>" alt="album cover">
                <h4 class="pl-2 my-auto" >{{ $songVoteOption->name }}</h4>
                <input type="checkbox" class="my-auto">
            </div>
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