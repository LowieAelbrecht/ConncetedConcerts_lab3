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
        <p>You will need to make a room for your concert. A room is a space where your fans will find your exclusive content and giveaways and more info about that concert.</p>
    </div>
    <div class="text-center">
        <a href="/user-rooms" class="skip">Skip</a>
        <span class="selected-dot dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <a href="/artist-tutorial3" class="next">Next</a>        
    </div>
</div>
@endsection