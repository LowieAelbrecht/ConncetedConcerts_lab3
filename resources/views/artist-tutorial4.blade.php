@extends('layouts/frontend')

@section('title')
   Tutorial artist
@endsection

@section('content')
<div class="tutorial-img">
    <img src="/images/tutorial-example.png" alt="">
</div>
<div class="tutorial">
    <div>
        <p>After choosing a room, You will need to select at least 2 songs from your catalogue. This gives your fans a chance to vote on which song they would like to hear.</p>
    </div>
    <div class="text-center">
        <a href="/user-rooms" class="skip">Skip</a>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="selected-dot dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <a href="/artist-tutorial5" class="next">Next</a>        
    </div>
</div>
@endsection