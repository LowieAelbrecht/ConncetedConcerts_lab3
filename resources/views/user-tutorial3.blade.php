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
        <p>On this page you will see a list of all of your upcoming concerts. To make a room of the concert of your choice you select it and you click "Next"</p>
    </div>
    <div class="text-center">
        <a href="/user-rooms" class="skip">Skip</a>
        <span class="dot"></span>
        <span class="selected-dot  dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <a href="/user-tutorial4" class="next">Next</a>        
    </div>
</div>
@endsection