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
        <p>On this page is where you add items you to give away to your fans. We use a randomizer to select the lucky winner.</p>
    </div>
    <div class="text-center">
        <a href="/user-rooms" class="skip">Skip</a>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="selected-dot  dot"></span>
        <span class="dot"></span>
        <a href="/user-tutorial6" class="next">Next</a>        
    </div>
</div>
@endsection