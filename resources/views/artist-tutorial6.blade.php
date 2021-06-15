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
        <p>On this page is where you get an overview of posts you posted. Fans that bought tickets to be in your room will be able to see, like  & comment on your posts.</p>
    </div>
    <div class="text-center">
        <a href="/user-rooms" class="skip">Skip</a>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="selected-dot  dot"></span>
        <a href="/user-rooms" class="next">Finish</a>        
    </div>
</div>
@endsection